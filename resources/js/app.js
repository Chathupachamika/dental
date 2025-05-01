import './bootstrap';
import Alpine from 'alpinejs';


// Import vendor dependencies
import Chart from 'chart.js/auto';
import ApexCharts from 'apexcharts';

// Load Google Charts
const loadGoogleCharts = () => {
    const script = document.createElement('script');
    script.src = 'https://www.gstatic.com/charts/loader.js';
    script.onload = () => {
        if (window.google && window.google.charts) {
            window.google.charts.load('current', {'packages':['corechart', 'controls']});
        }
    };
    document.head.appendChild(script);
};

// Initialize components
window.Alpine = Alpine;
window.Chart = Chart;
window.ApexCharts = ApexCharts;
loadGoogleCharts();

Alpine.start();
