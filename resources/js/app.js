import Alpine from 'alpinejs';
import '../../vendor/sampaui/sampaui/dist/sampaui.js';

window.Alpine = Alpine;

Alpine.data('docSearch', (items = []) => ({
    query: '',
    open: false,
    activeIndex: 0,
    items,
    normalize(value) {
        return String(value ?? '')
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .toLowerCase();
    },
    get results() {
        const term = this.normalize(this.query);

        if (! term) {
            return [];
        }

        return this.items
            .filter((item) => this.normalize(item.search).includes(term))
            .slice(0, 12);
    },
    get hasResults() {
        return this.results.length > 0;
    },
    select(index = this.activeIndex) {
        const item = this.results[index];

        if (item?.url) {
            window.location.href = item.url;
        }
    },
    next() {
        if (! this.hasResults) {
            return;
        }

        this.activeIndex = (this.activeIndex + 1) % this.results.length;
    },
    previous() {
        if (! this.hasResults) {
            return;
        }

        this.activeIndex = this.activeIndex === 0 ? this.results.length - 1 : this.activeIndex - 1;
    },
}));

Alpine.data('siteVisitsChart', () => ({
    chart: null,
    async init() {
        const { default: ApexCharts } = await import('apexcharts');

        window.ApexCharts = ApexCharts;

        const colors = {
            primary: '#5574C9',
            secondary: '#2E314A',
            accent: '#FDB82E',
            light: '#F4F6FA',
            success: '#79C8BC',
            purple: '#895FC4',
            paper: '#F4F6FA',
            white: '#FFFFFF',
        };

        this.chart = new ApexCharts(this.$refs.chart, {
            chart: {
                type: 'line',
                height: 335,
                parentHeightOffset: 0,
                sparkline: { enabled: false },
                toolbar: { show: false },
                zoom: { enabled: false },
                fontFamily: 'Plus Jakarta Sans, Outfit, ui-sans-serif, system-ui, sans-serif',
                foreColor: colors.secondary,
                animations: {
                    enabled: true,
                    speed: 650,
                    animateGradually: { enabled: true, delay: 80 },
                    dynamicAnimation: { enabled: true, speed: 350 },
                },
            },
            series: [
                {
                    name: 'Visitas do site',
                    type: 'area',
                    data: [1820, 2260, 2440, 3180, 3710, 3290, 3780],
                },
                {
                    name: 'Casa Jardim Europa',
                    type: 'column',
                    data: [280, 390, 420, 510, 620, 480, 584],
                },
            ],
            labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab', 'Dom'],
            colors: [colors.primary, colors.accent],
            stroke: {
                width: [4, 0],
                curve: 'smooth',
                lineCap: 'round',
            },
            fill: {
                type: ['gradient', 'solid'],
                opacity: [0.2, 0.78],
                gradient: {
                    shadeIntensity: 0.2,
                    opacityFrom: 0.32,
                    opacityTo: 0.02,
                    stops: [0, 90, 100],
                },
            },
            plotOptions: {
                bar: {
                    columnWidth: '30%',
                    borderRadius: 8,
                    borderRadiusApplication: 'end',
                },
            },
            markers: {
                size: [5, 0],
                strokeWidth: 3,
                strokeColors: colors.white,
                hover: { size: 7 },
            },
            dataLabels: { enabled: false },
            legend: {
                show: false,
            },
            grid: {
                borderColor: 'rgba(46, 49, 74, 0.10)',
                strokeDashArray: 4,
                padding: { left: 10, right: 16, top: 10, bottom: 0 },
            },
            states: {
                hover: { filter: { type: 'none' } },
                active: { filter: { type: 'none' } },
            },
            tooltip: {
                shared: true,
                intersect: false,
                marker: { show: true },
                style: { fontSize: '12px' },
                y: {
                    formatter: (value) => `${Intl.NumberFormat('pt-BR').format(value)} visitas`,
                },
            },
            annotations: {
                points: [
                    {
                        x: 'Dom',
                        y: 584,
                        seriesIndex: 1,
                        marker: {
                            size: 6,
                            fillColor: colors.accent,
                            strokeColor: colors.white,
                            strokeWidth: 3,
                        },
                        label: {
                            borderColor: colors.primary,
                            offsetY: -8,
                            style: {
                                background: colors.primary,
                                color: colors.white,
                                fontSize: '11px',
                                fontWeight: 600,
                            },
                            text: 'Top: Casa Jardim Europa',
                        },
                    },
                ],
            },
            xaxis: {
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    offsetY: 4,
                    style: {
                        colors: colors.secondary,
                        fontWeight: 700,
                        fontSize: '12px',
                    },
                },
                tooltip: { enabled: false },
            },
            yaxis: [
                {
                    min: 1500,
                    max: 4000,
                    tickAmount: 5,
                    title: { show: false },
                    labels: {
                        offsetX: -6,
                        style: {
                            colors: colors.secondary,
                            fontWeight: 600,
                        },
                        formatter: (value) => Intl.NumberFormat('pt-BR', { notation: 'compact' }).format(value),
                    },
                },
                {
                    opposite: true,
                    min: 0,
                    max: 1000,
                    tickAmount: 5,
                    title: { show: false },
                    labels: {
                        offsetX: 8,
                        style: {
                            colors: colors.secondary,
                            fontWeight: 600,
                        },
                        formatter: (value) => Intl.NumberFormat('pt-BR').format(value),
                    },
                },
            ],
            responsive: [
                {
                    breakpoint: 768,
                    options: {
                        chart: { height: 300 },
                        grid: { padding: { left: 0, right: 4, top: 8, bottom: 0 } },
                        yaxis: [
                            { labels: { show: false }, title: { show: false } },
                            { labels: { show: false }, title: { show: false } },
                        ],
                    },
                },
            ],
        });

        this.chart.render();
    },
    destroy() {
        this.chart?.destroy();
    },
}));

Alpine.start();
