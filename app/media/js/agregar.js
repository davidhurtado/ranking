$(document).on("ready", function () {
});
function refreshTable() {
    $("#addrow").on("click", function (e) {
        setTimeout(refreshTable, 500);
        location.href = "movimiento?accion=agregarcarrito";
    });
    location.href = "movimiento?accion=agregarcarrito";
}
;
function refreshTableUnica(frm) {
    $("#addrow").on("click", function (e) {
        setTimeout(refreshTable, 500);
        location.href = "movimiento?accion=agregarcarrito";
    });
    location.href = "movimiento?accion=agregarcarrito";
}
;
function addRow(tableID) {
    var frm = $("#frmUser").serialize();
    $.ajax({
        type: "POST",
        url: "movimiento?accion=agregarproforma",
        data: frm
    }).done(function (info) {
        refreshTable();
    });

}
function addRowProducto(tableID) {
    var frm = $("#frmProforma").serialize();
    $.ajax({
        type: "POST",
        url: "movimiento?accion=estaproforma",
        data: frm
    }).done(function (info) {
        refreshTableUnica(frm);
    });

}
function Facturar() {
    var frm = $("#frmFacturar").serialize();
    $.ajax({
        type: "POST",
        url: "movimiento?accion=facturar",
        data: frm
    }).done(function (info) {
        location.href = "movimiento?accion=verfactura";
    });

}
