<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Do</title>
    <style>
        .page-break {
        page-break-after: always;
        }
    </style>
</head>
<body>
    @forelse ($perangkat as $sn)
        <table width="100%" style="border-style: solid; border-width: 3px; font-weight: bold; margin: auto;">
            {{-- Header --}}
                <tr>
                    <td>
                        <table align="center">
                            <tr>
                                <td style="text-align: left; padding-left: 5vh; padding-right: 5vh;">
                                    {{-- Untuk Production --}}
                                        <img width="100" src="{{ base_path('public/images/pins_logo.jpg') }}" alt="Logo Pins">
                                    {{-- Untuk Development --}}
                                        {{-- <img width="100" src="{{ asset('images/pins_logo.jpg') }}" alt="Logo Pins"> --}}
                                </td>
                                <td style="text-align: center; padding-left: 5vh; padding-right: 5vh;">
                                    SEAT MANAGEMENT V
                                    <br>
                                    PROGRAM CYOD DAN NON CYOD
                                </td>
                                <td style="text-align: right; padding-left: 5vh; padding-right: 5vh;">
                                    {{-- Untuk Production --}}
                                        <img width="100" src="{{ base_path('public/images/telkom_logo.jpg') }}" alt="Logo telkom">
                                    {{-- Untuk Development --}}
                                        {{-- <img width="100" src="{{ asset('images/telkom_logo.jpg') }}" alt="Logo telkom"> --}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            {{-- End Header --}}

            {{-- DO Text --}}
                <tr style="text-align: center;">
                    <td style="background-color: gainsboro;" colspan="2">Delivery Order</td>
                </tr>
            {{-- DO Text --}}

            {{-- Information --}}
                <tr>
                    <td>
                        <table>
                            <tr>
                                {{-- Kiri --}}
                                    <td>
                                        <table style="font-size: 13px">
                                            <tr>
                                                <td style="vertical-align: top" width="28%">Penerima</td>
                                                <td style="vertical-align: top" width="2%">:</td>
                                                <td style="vertical-align: top" width="70%" style="font-size: 13px; text-transform: capitalize">WITEL ACEH</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td style="font-size: 13px; text-transform: capitalize">PT Telekomunikasi Indonesia, Tbk</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: top">Alamat Penerima</td>
                                                <td style="vertical-align: top">:</td>
                                                <td style="vertical-align: top; font-size: 12px; text-transform: capitalize">IS OPERATION TELKOM WITEL ACEH Jl. S.A. MAHMUDSYAH NO.10 BANDA ACEH</td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: top">PIC</td>
                                                <td style="vertical-align: top">:</td>
                                                <td style="font-size: 13px; text-transform: capitalize; vertical-align: top">ZULKARNAIN</td>
                                            </tr>
                                            <tr>
                                                <td>Telepon</td>
                                                <td>:</td>
                                                <td style="font-size: 13px; text-transform: capitalize">08116897488 / 0651-29444</td>
                                            </tr>
                                        </table>
                                    </td>
                                {{-- End Kiri --}}
                                {{-- Kanan --}}
                                    <td>
                                        <table style="font-size: 13px;">
                                            <tr>
                                                <td width="28%">Nomor DO</td>
                                                <td width="2%">:</td>
                                                <td width="70%" style="text-transform: uppercase; font-size: 13px">do-501554</td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal DO</td>
                                                <td>:</td>
                                                <td style="text-transform: uppercase; font-size: 13px">20 Desember 2019</td>
                                            </tr>
                                            <tr>
                                                <td>Pengirim</td>
                                                <td>:</td>
                                                <td style="text-transform: uppercase; font-size: 13px">PT. PINS INDONESIA</td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: top">Alamat Pengirim</td>
                                                <td style="vertical-align: top">:</td>
                                                <td style="text-transform: uppercase; font-size: 12px; ">Gedung Telkom Landmark Tower Lt. 42-43 Jl. Gatot Subroto Kav. 52 Jakarta Selatan</td>
                                            </tr>
                                            <tr>
                                                <td>PIC</td>
                                                <td>:</td>
                                                <td style="text-transform: uppercase; font-size: 13px">Ramdhan</td>
                                            </tr>
                                            <tr>
                                                <td>Telepon</td>
                                                <td>:</td>
                                                <td style="text-transform: uppercase; font-size: 13px">082121254001</td>
                                            </tr>
                                        </table>
                                    </td>
                                {{-- End Kanan --}}
                            </tr>
                        </table>
                    </td>
                </tr>
            {{-- Information --}}

            {{-- Content & SN --}}
                <tr>
                    <td>
                        <table width="100%" border="1">
                            <tr align="center">
                                <td width="5%" rowspan="2"></td>
                                <td width="15%" rowspan="2">Nama Barang</td>
                                <td width="55%" rowspan="2">Serial Number</td>
                                <td width="25%" colspan="2">Kiriman</td>
                            </tr>
                            <tr align="center">
                                <td>Jumlah</td>
                                <td>Satuan</td>
                            </tr>
                            <tbody>
                                <tr style="font-size: 13px;">
                                    
                                    <td style="vertical-align: top; text-align: center; padding-top: 5px;">1</td>
                                    <td style="padding: 5px; vertical-align: top; text-align: left; padding-top: 5px;">{{ $namaPerangkat }}</td>
                                    <td style="padding: 5px;">
                                    @foreach ($sn as $data)
                                        {{ $data['sn_pengganti'] }} &nbsp;&nbsp;
                                    @endforeach
                                    </td>
                                    <td style="vertical-align: top; text-align: center; padding-top: 5px;">{{ $totalPerangkat }}</td>
                                    <td style="vertical-align: top; text-align: center; padding-top: 5px;">Unit</td>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td style="font-size: 13px;">
                                    Keterangan  :
                                    <br>
                                    <br>
                                    Syarat dan Ketentuan : <br>
                                    1.	Apabila barang yang diterima jumlahnya tidak sesuai, Seal / lakban terbuka, dus kondisi basah dan sejenisnya, dus rusak / sobek, mohon untuk memberikan catatan pada Delivery Order sebelum menandatangani-nya; <br>
                                    2.	Kondisi barang selama pengiriman menjadi tanggung jawab pengirim; <br>
                                    3.	Pelanggan disarankan membuka kardus bersama-sama dengan tim deploy PINS. <br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            {{-- End Content & SN --}}

            {{-- Note & TTD --}}
                <tr>
                    <td>
                        <table width="100%" border="1" style="font-size: 13px;">
                            <tr>
                                <td>Dibuat Oleh</td>
                                <td>Disiapkan Oleh</td>
                                <td>Dikirim Oleh</td>
                                <td>Diterima Oleh</td>
                            </tr>
                            <tr>
                                <td> <br><br><br><br><br><br> </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Nama:</td>
                                <td>Nama:</td>
                                <td>Nama:</td>
                                <td>Nama:</td>
                            </tr>
                            <tr>
                                <td>Jabatan:</td>
                                <td>Jabatan:</td>
                                <td>Jabatan:</td>
                                <td>Jabatan:</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            {{-- End Note & TTD --}}
        </table>
        <div class="page-break"></div>
    @empty
    Kosong
    @endforelse
</body>
</html>