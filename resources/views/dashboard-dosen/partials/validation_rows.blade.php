@if ($permintaanTerbarus->isEmpty())
    <tr>
        <td colspan="4" class="text-center font-weight-bold p-4">
            Tidak ada permintaan validasi baru.
        </td>
    </tr>
@else
    @foreach ($permintaanTerbarus as $permintaanTerbaru)
        <tr>
            <td style="width: auto; white-space: nowrap;">
                <div class="px-0">
                    <div class="my-auto ms-2">
                        <h6 class="mb-0 text-md">{{ $permintaanTerbaru->mahasiswa->nama }}</h6>
                    </div>
                </div>
            </td>
            <td>
                <p class="text-md font-weight-normal mb-0">{{ $permintaanTerbaru->type }}</p>
            </td>
            <td>
                <p class="text-md font-weight-normal mb-0">
                    {{ $permintaanTerbaru->created_at->format('d M Y') }}
                </p>
            </td>
            <td class="text-center">
                @php
                    $filePath = null;
                    switch (strtolower($permintaanTerbaru->type)) {
                        case 'irs':
                            $filePath = $permintaanTerbaru->file_sks;
                            break;
                        case 'khs':
                            $filePath = $permintaanTerbaru->file_khs;
                            break;
                        case 'pkl':
                            $filePath = $permintaanTerbaru->file_pkl;
                            break;
                        case 'skripsi':
                            $filePath = $permintaanTerbaru->file_skripsi;
                            break;
                    }
                    $fileUrl = $filePath ? (Str::startsWith($filePath, 'http') ? $filePath : route('dokumen.show', ['type' => strtolower($permintaanTerbaru->type), 'id' => $permintaanTerbaru->id])) : '#';
                @endphp
                <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-info px-2 py-1 {{ $filePath ? '' : 'disabled' }}"
                    title="Lihat Berkas">
                    <i class="material-icons">visibility</i>
                </a>

                <a href="javascript:void(0)" onclick="handleValidation({{ $permintaanTerbaru->id }}, 'approve','{{ $permintaanTerbaru->type }}')"
                    class="btn btn-outline-success px-2 py-1" title="Setujui">
                    <i class="material-icons">check</i>
                </a>

                <a href="javascript:void(0)" onclick="handleValidation({{ $permintaanTerbaru->id }}, 'reject','{{ $permintaanTerbaru->type }}')"
                    class="btn btn-outline-danger px-2 py-1" title="Tolak">
                    <i class="material-icons">close</i>
                </a>
            </td>
        </tr>
    @endforeach
@endif
