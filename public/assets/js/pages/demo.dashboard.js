jQuery(document).ready(function () {

    $("#dash-daterange").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true, // Opcional para mostrar dropdowns de selección de mes y año
        minYear: 2020, // Opcional para establecer el año mínimo seleccionable
        maxYear: parseInt(moment().format("YYYY"), 10), //Opcional para establecer el año máximo seleccionable
        locale: { format: "YYYY-MM-DD" }, // Opcional para establecer el formato de fecha
    });

    // Actualizar el valor del input con la fecha actual
    $("#dash-daterange").val(moment().format("YYYY-MM-DD"));

    // Opciones de gráficos de muestra
    var sampleChartOptions = {
        chart: { height: 257, type: "bar", stacked: !0 },
        plotOptions: { bar: { horizontal: !1, columnWidth: "20%" } },
        dataLabels: { enabled: !1 },
        stroke: { show: !0, width: 2, colors: ["transparent"] },
        series: [
            {
                name: "Actual",
                data: [65, 59, 80, 81, 56, 89, 40, 32, 65, 59, 80, 81],
            },
            {
                name: "Projection",
                data: [89, 40, 32, 65, 59, 80, 81, 56, 89, 40, 65, 59],
            },
        ],
        zoom: { enabled: !1 },
        legend: { show: !1 },
        colors: ["#727cf5", "#e3eaef"],
        xaxis: {
            categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ],
            axisBorder: { show: !1 },
        },
        yaxis: {
            labels: {
                formatter: function (e) {
                    return e + "k";
                },
                offsetX: -15,
            },
        },
        fill: { opacity: 1 },
        tooltip: {
            y: {
                formatter: function (e) {
                    return "$" + e + "k";
                },
            },
        },
    };

    // Inicializar los gráficos
    var highPerformingProduct = new ApexCharts(
        document.getElementById("high-performing-product"),
        sampleChartOptions
    );

    highPerformingProduct.render();
});
