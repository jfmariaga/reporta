<div class="container-fluid">
    <div class="row">
        {{-- Gráfica por Área --}}
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Reportes por Área</h3>
                </div>
                <div class="card-body">
                    <div id="chartAreas"></div>
                </div>
            </div>
        </div>

        {{-- Gráfica por Estado --}}
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Reportes por Estado</h3>
                </div>
                <div class="card-body">
                    <div id="chartEstados"></div>
                </div>
            </div>
        </div>

        {{-- Gráfica por Impactos --}}
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Reportes por Sistemas de Gestión</h3>
                </div>
                <div class="card-body">
                    <div id="chartImpactos"></div>
                </div>
            </div>
        </div>

        {{-- Treemap Zonas con mayor impacto --}}
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Reportes por Área y Estado</h3>
                </div>
                <div class="card-body">
                    <div id="chartAreasEstados"></div>
                </div>
            </div>

        </div>

        {{-- Gráfica Barras Apiladas por Área y Estado --}}
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Zonas con Mayor Impacto</h3>
                </div>
                <div class="card-body">
                    <div id="chartZonas"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', function() {

            new ApexCharts(document.querySelector("#chartAreasEstados"), {
                chart: {
                    type: 'bar',
                    height: 400,
                    stacked: true
                },
                series: @json($seriesAreasEstados),
                xaxis: {
                    categories: @json($labelsAreasEstados)
                }, // <<< aquí el cambio
                colors: ['#4e73df', '#36b9cc', '#1cc88a', '#e74a3b', '#f6c23e', '#858796', '#5a5c69'],
                legend: {
                    position: 'bottom'
                }
            }).render();

            // Gráfica por Área
            new ApexCharts(document.querySelector("#chartAreas"), {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'Reportes',
                    data: @json($seriesAreas)
                }],
                xaxis: {
                    categories: @json($labelsAreas)
                },
                colors: ['#4e73df']
            }).render();

            // Gráfica por Impactos
            new ApexCharts(document.querySelector("#chartImpactos"), {
                chart: {
                    type: 'donut',
                    height: 350
                },
                series: @json($seriesImpactos),
                labels: @json($labelsImpactos),
                legend: {
                    position: 'right'
                },
                dataLabels: {
                    enabled: true,
                    formatter: val => val.toFixed(1) + "%"
                }
            }).render();

            // Gráfica por Estado
            new ApexCharts(document.querySelector("#chartEstados"), {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'Reportes',
                    data: @json($seriesEstados)
                }],
                xaxis: {
                    categories: @json($labelsEstados)
                },
                colors: ['#1cc88a']
            }).render();

            // Treemap Zonas con mayor impacto
            new ApexCharts(document.querySelector("#chartZonas"), {
                chart: {
                    type: 'treemap',
                    height: 350
                },
                series: @json($seriesZonasImpacto),
                colors: ['#4e73df', '#36b9cc', '#e74a3b', '#f6c23e', '#1cc88a']
            }).render();

        });
    </script>
</div>
