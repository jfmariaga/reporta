<div>
    <style>
        #chartContainer {
            width: 100%;
            height: 400px;
            position: relative;
        }
    </style>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Gráfica por Estado</h3>
            <div class="card-tools">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-eye"></i></button>
            </div>
        </div>
        <div id="chartContainer" class="card-body">
            <canvas id="myDonutChart" width="400" height="200"></canvas>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:init', function() {
            var chart;
            console.log('Chart data:', @json($chartData)); // Agrega esto para depurar

            function renderChart(data) {
                var ctx = document.getElementById('myDonutChart').getContext('2d');
                if (chart) {
                    chart.destroy();
                }
                chart = new Chart(ctx, {
                    type: 'doughnut',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    }
                });
            }

            renderChart(@json($chartData));

            Livewire.on('chartDataUpdated', (data) => {
                renderChart(data.chartData);
            });
        });
    </script>
</div>
