@extends('template.app')

@section('content-dinamis')
    <div class="container mt-5">
        <h3 class="text-center mb-3">Jumlah laporan dan tanggapan</h3>
        <canvas id="reportsChart" style="max-height: 500px;"></canvas>
    </div>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('{{ route("report.by.province") }}')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.province_name);
                const totalReports = data.map(item => item.total_reports);  
                const doneCount = data.map(item => item.done_count);
                const onProcessCount = data.map(item => item.on_process_count);
                const rejectCount = data.map(item => item.reject_count);

                const ctx = document.getElementById('reportsChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Jumlah Laporan',
                                data: totalReports,
                                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'DONE',
                                data: doneCount,
                                backgroundColor: 'rgba(0, 255, 0, 0.6)',
                                borderColor: 'rgba(0, 255, 0, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'ON PROCESS',
                                data: onProcessCount,
                                backgroundColor: 'rgba(255, 165, 0, 0.6)',
                                borderColor: 'rgba(255, 165, 0, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'REJECTED',
                                data: rejectCount,
                                backgroundColor: 'rgba(255, 0, 0, 0.6)',
                                borderColor: 'rgba(255, 0, 0, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching chart data:', error));
    });
</script>
@endpush
