<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
                -webkit-print-color-adjust: exact; /* Adjust for printing colors */
            }
            .container {
                width: 210mm; /* Width for A4 */
                height: auto; /* Automatic height */
                margin: 0 auto; /* Center the content */
                padding: 10mm; /* Reduce padding for print */
            }
        }

        /* General Styles */
        body {
            background-color: #f3f4f6; /* Gray background */
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px; /* Reduced width */
            margin: auto;
            padding: 10px; /* Reduced padding */
        }

        .receipt {
            background-color: #fff; /* White background */
            border-radius: 8px; /* Smaller border radius */
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); /* Reduced shadow */
            padding: 15px; /* Reduced padding */
            margin-bottom: 10px; /* Reduced margin */
            position: relative;
        }

        .receipt:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px; /* Reduced height */
            background-color: #34d399; /* Green accent */
            border-radius: 8px 8px 0 0; /* Smaller radius */
        }

        h2 {
            font-size: 24px; /* Reduced font size */
            font-weight: bold;
            margin-bottom: 15px; /* Reduced margin */
            color: #1f2937; /* Dark gray */
        }

        /* Grid Styles */
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px; /* Reduced gap */
        }

        /* Item Styles */
        .details .item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px; /* Reduced margin */
            font-size: 12px; /* Reduced font size */
            color: #374151; /* Dark gray */
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
            margin-bottom: 15px; /* Reduced margin */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px; /* Reduced margin */
        }

        th, td {
            padding: 8px 10px; /* Reduced padding */
            text-align: left;
            font-size: 12px; /* Reduced font size */
        }

        th {
            background-color: #e5e7eb; /* Gray background */
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9fafb; /* Light gray for even rows */
        }

        td .sku {
            display: block;
            font-size: 10px; /* Reduced font size */
            color: #6b7280; /* Gray text */
        }

        /* Additional Information Styles */
        .additional-info {
            background-color: #f9fafb; /* Light gray background */
            padding: 15px; /* Reduced padding */
            border-radius: 6px; /* Smaller border radius */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Reduced shadow */
        }

        .notes {
            margin-bottom: 15px; /* Reduced margin */
        }

        .notes label {
            font-weight: bold;
            color: #1f2937; /* Dark gray */
        }

        textarea {
            width: 100%;
            padding: 8px; /* Reduced padding */
            border: 1px solid #d1d5db; /* Gray border */
            border-radius: 4px;
            resize: none;
            font-size: 12px; /* Reduced font size */
            background-color: #ffffff; /* White background for textarea */
        }

        .summary .item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px; /* Reduced margin */
            font-size: 12px; /* Reduced font size */
        }

        .success {
            color: #16a34a; /* Green for success */
            font-weight: bold;
        }

        .error {
            color: #dc2626; /* Red for error */
            font-weight: bold;
        }


    </style>
</head>
<body>
    <div class="container">
        <!-- Transaction Details Section -->
        <div class="receipt">
            <h2>Detail Transaksi</h2>
            <div class="grid">
                <div class="details">
                    <div class="item"><strong>Resi:</strong> <span>{{ $transaksi->resi }}</span></div>
                    <div class="item"><strong>Tanggal / Waktu:</strong> <span>{{ $transaksi->created_at }}</span></div>
                    <div class="item"><strong>Tanggal:</strong> <span>{{ $transaksi->tanggal_transaksi }}</span></div>
                    <div class="item"><strong>Status:</strong> <span>{{ $transaksi->status }}</span></div>
                </div>
                <div class="details">
                    <div class="item"><strong>Nama Pembeli:</strong> <span>{{ $transaksi->nama_pembeli ?? 'No Name' }}</span></div>
                    <div class="item"><strong>Outlet:</strong> <span>{{ $transaksi->outlet->nama_outlet }}</span></div>
                    <div class="item"><strong>Alamat:</strong> <span>{{ $transaksi->outlet->alamat }}</span></div>
                    <div class="item"><strong>No Telepon:</strong> <span>{{ $transaksi->outlet->no_telp }}</span></div>
                </div>
            </div>

            <!-- Order Details Table -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>QTY</th>
                            <th>Status</th>
                            <th>Harga</th>
                            <th>Satuan</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($detailTransaksis as $key => $items)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <span class="font-medium">{{ $items->Produk->nama_produk }}</span>
                                    <span class="sku">SKU: {{ $items->produk->sku }}</span>
                                </td>
                                <td>{{ $items->Produk->Kategori->nama_kategori }}</td>
                                <td>{{ $items->jumlah_barang }}</td>
                                <td>{{ $items->status }}</td>
                                <td>
                                    @if($items->status == 'Diskon')
                                        {{ $items->Produk->harga_diskon ?? ($items->subtotal / $items->jumlah_barang) }} ({{ $items->Produk->diskon ?? $items->diskon }})
                                    @else
                                        {{ $items->Produk->harga_jual }}
                                    @endif
                                </td>
                                <td>{{ $items->Produk->Unit->nama_unit }}</td>
                                <td>{{ number_format($items->subtotal, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center;">No produk found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Additional Information -->
            <div class="additional-info">
                <div class="grid">
                    <div class="notes">
                        <label for="Catatan">Catatan:</label>
                        <textarea id="Catatan" rows="10" readonly>{{ $transaksi->catatan }}</textarea>
                    </div>

                    <div class="summary">
                        <div class="item"><strong>Subtotal:</strong> <span>{{ number_format($transaksi->total_belanja, 2) }}</span></div>
                        <div class="item"><strong>Diskon:</strong> <span>{{ $transaksi->diskon . " %" ?? '0%' }}</span></div>
                        <div class="item"><strong>Penyesuaian:</strong> <span>-</span></div>
                        <div class="item"><strong>Total:</strong> <span>{{ number_format($transaksi->total_belanja, 2) }}</span></div>
                        <div class="item"><strong>Sisa Tagihan:</strong>
                            <span class="{{ $transaksi->status == 'Selesai' ? 'success' : 'error' }}">
                                {{ $transaksi->status == 'Selesai' ? 'Lunas' : 'Cancelled' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
