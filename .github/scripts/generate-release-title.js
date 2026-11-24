import { execSync } from "node:child_process";

const openRouterApiKey = process.env.OPENROUTER_API_KEY;
const releaseModelName = process.env.RELEASE_TITLE_MODEL || "meta-llama/llama-3.3-70b-instruct:free";

if (!openRouterApiKey) {
  console.error("[fail-closed] Missing OPENROUTER_API_KEY environment variable.");
  process.exit(1);
}

// 1. Collect conventional commits since the latest git tag
let rawCommitLines = [];
try {
  const latestGitTag = execSync("git describe --tags --abbrev=0 2>/dev/null || true")
    .toString()
    .trim();
  const revisionTarget = latestGitTag ? `${latestGitTag}..HEAD` : "HEAD";
  const gitLogOutput = execSync(`git log ${revisionTarget} --pretty=format:"* %s"`)
    .toString()
    .trim();

  if (gitLogOutput) {
    rawCommitLines = gitLogOutput.split("\n").filter((line) => line.trim().length > 0);
  }
} catch (error) {
  console.error("[fail-closed] Failed to retrieve git commit history:", error.message);
  process.exit(1);
}

if (rawCommitLines.length === 0) {
  console.log("Routine maintenance and stability improvements");
  process.exit(0);
}

const commitLogSummary = rawCommitLines.slice(0, 30).join("\n");

// 2. Synthesize a human-like, non-robotic release title via OpenRouter
const llmPrompt = `You are an expert software release manager. Analyze the following conventional commit messages for a software release and synthesize a concise, high-level, human-readable release title.

Rules:
1. Maximum 8-10 words.
2. Focus on the primary user-facing feature or core architectural change.
3. Plain language only. Do NOT output prefixes like "Release: ", "Title: ", markdown formatting, or quotes.
4. Output ONLY the raw single-line title.

Commits:
${commitLogSummary}`;

try {
  const response = await fetch("https://openrouter.ai/api/v1/chat/completions", {
    method: "POST",
    headers: {
      Authorization: `Bearer ${openRouterApiKey}`,
      "Content-Type": "application/json",
      "HTTP-Referer": "https://github.com/Churma16/ppl-reborn-siap-undip",
      "X-Title": "PPL SIAP Release Title Synthesizer",
    },
    body: JSON.stringify({
      model: releaseModelName,
      messages: [{ role: "user", content: llmPrompt }],
      temperature: 0.3,
      max_tokens: 50,
    }),
  });

  if (!response.ok) {
    const errorBody = await response.text();
    console.error(`[fail-closed] OpenRouter API error (HTTP ${response.status}): ${errorBody}`);
    process.exit(1);
  }

  const result = await response.json();
  const releaseTitle = result.choices?.[0]?.message?.content?.trim();

  if (!releaseTitle) {
    console.error("[fail-closed] OpenRouter returned an empty release title.");
    process.exit(1);
  }

  // Strip wrapping quotation marks if present
  const cleanedTitle = releaseTitle.replace(/^["']|["']$/g, "").trim();
  console.log(cleanedTitle);
} catch (error) {
  console.error("[fail-closed] Error communicating with OpenRouter API:", error.message);
  process.exit(1);
}
