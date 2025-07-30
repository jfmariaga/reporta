<div>
    <style>
        #chartContainer {
            width: 100%;
            height: 400px;
            /* Puedes ajustar la altura según tus necesidades */
            position: relative;
        }
    </style>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Grafica por Areas</h3>
            <div class="card-tools">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-eye"></i></button>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div id="chartContainer" class="card-body">
            <canvas id="myChart" width="400" height="200"></canvas>
        </div>

    </div>
    <!-- /.card -->
    <script>
        document.addEventListener('livewire:init', function() {

            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: @json($chartData),
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Livewire.on('chartDataUpdated', () => {
            //     chart.data = @json($chartData);
            //     chart.update();
            //     console.log('grafica actualizada');
            // });
        });
    </script>

</div>
