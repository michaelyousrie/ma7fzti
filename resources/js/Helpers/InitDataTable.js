function InitDataTable( elem ) {
    $.fn.dataTable.ext.errMode = 'none';

    elem.DataTable({
        dom: 't<"row"<"col-md-4" l><"col-md-4 text-center" f> <"col-md-4 text-center" p>>',
    });
}

export {
    InitDataTable
}
