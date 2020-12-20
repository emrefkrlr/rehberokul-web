/*
Name: 			Tables / Advanced - Examples
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	1.5.2
*/



(function($) {

	'use strict';




	var datatableInit = function() {
		var $table = $('#datatable-tabletools').DataTable({
                        "columnDefs": [ {
                                "targets": [0, 1, 2, 3, 4, 5, 6],
                                "orderable": false
                            }
                        ],
                        
                        deferRender: true,
            "bStateSave": false,

			sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
			"language": {
			    "sDecimal":        ",",
			    "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
			    "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
			    "sInfoEmpty":      "Kayıt yok",
			    "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
			    "sInfoPostFix":    "",
			    "sInfoThousands":  ".",
			    "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
			    "sLoadingRecords": "Yükleniyor...",
			    "sProcessing":     "İşleniyor...",
			    "sZeroRecords":    "Eşleşen kayıt bulunamadı",
                            "searchPlaceholder": "Search records",
			    "oPaginate": {
			        "sFirst":    "İlk",
			        "sLast":     "Son",
			        "sNext":     "Sonraki",
			        "sPrevious": "Önceki"
			    },
			    "oAria": {
			        "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
			        "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
			    }
			},               
			oTableTools: {
				aButtons: [
//					{
//						sExtends: 'pdf',
//						sButtonText: 'PDF'
//					},
//					{
//						sExtends: 'csv',
//						sButtonText: 'CSV'
//					},
//					{
//						sExtends: 'xls',
//						sButtonText: 'Excel'
//					},
					{
						sExtends: 'print',
						sButtonText: 'Yazdır',
						sInfo: 'Çıktı almak için CTR+P basınız. Çıkmak için ESC tuşuna basınız.'
					}
				]
			}
		});


                //Sıraları yazdırır
                $table.on( 'order.dt search.dt', function () {
                    $table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                        cell.innerHTML = i+1;
                    } );
                } ).draw();

                $table.columns().every( function () {
                    var that = this;

                    if(that.header().innerHTML !== '<div class="form-group form-group-sm is-empty"><div>Son Giriş</div><div class="input-daterange input-group datepicker-orient-top" data-plugin-datepicker=""><input type="text" data-date-format="yyyy-mm-dd" placeholder="Başlangıç" class="form-control" name="start" id="start"><br><input type="text" data-date-format="yyyy-mm-dd" placeholder="Bitiş" class="form-control" name="end" id="end"></div></div>') {

                        $( 'input', this.header() ).on( 'keyup change', function () {

                            if ( that.search() !== this.value ) {
                                that
                                    .search( this.value )
                                    .draw();
                            }
                        } );

                    } else {
                        $( 'input', this.header() ).on( 'keyup change', function () {
                            $.fn.dataTableExt.afnFiltering.push(
                                function (oSettings, aData, iDataIndex) {
                                    var dateStart = parseDateValue($("#start").val());
                                    var dateEnd = parseDateValue($("#end").val());
                                    // aData represents the table structure as an array of columns, so the script access the date value
                                    // in the first column of the table via aData[0]
                                    var evalDate = parseDateValue(aData[4]);
                                    if(dateStart == 'undefinedundefined') {
                                        dateStart = '20200101';
                                    }


                                    if (evalDate >= dateStart && evalDate <= dateEnd) {
                                        return true;
                                    } else {
                                        return false;
                                    }

                                });

                            // Function for converting a mm/dd/yyyy date value into a numeric string for comparison (example 08/12/2010 becomes 20100812
                            function parseDateValue(rawDate) {
                                var dateArray = rawDate.split("-");
                                var parsedDate = dateArray[0] + dateArray[1] + dateArray[2];
                                return parsedDate;
                            }

                            that.draw();
                        })
                    }








                } );

	};





	$(function() {
		datatableInit();





		$(".dataTables_filter input").attr("placeholder", "Ara...");
        $('#datatable-tabletools thead th').removeClass("sorting_asc");
                
	});




}).apply(this, [jQuery]);



(function($) {

    'use strict';

    var datatableInit = function() {
        var $table = $('#datatable-tabletools-kindergarten').DataTable({
            "columnDefs": [ {
                "targets": [0, 1, 2, 3, 4, 6, 7, 8],
                "orderable": false
            }
            ],
            sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
            "language": {
                "sDecimal":        ",",
                "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
                "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                "sInfoEmpty":      "Kayıt yok",
                "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ".",
                "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
                "sLoadingRecords": "Yükleniyor...",
                "sProcessing":     "İşleniyor...",
                "sZeroRecords":    "Eşleşen kayıt bulunamadı",
                "searchPlaceholder": "Search records",
                "oPaginate": {
                    "sFirst":    "İlk",
                    "sLast":     "Son",
                    "sNext":     "Sonraki",
                    "sPrevious": "Önceki"
                },
                "oAria": {
                    "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                    "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
                }
            },
            oTableTools: {
                aButtons: [
//					{
//						sExtends: 'pdf',
//						sButtonText: 'PDF'
//					},
//					{
//						sExtends: 'csv',
//						sButtonText: 'CSV'
//					},
//					{
//						sExtends: 'xls',
//						sButtonText: 'Excel'
//					},
                    {
                        sExtends: 'print',
                        sButtonText: 'Yazdır',
                        sInfo: 'Çıktı almak için CTR+P basınız. Çıkmak için ESC tuşuna basınız.'
                    }
                ]
            }
        });
        //Sıraları yazdırır
        $table.on( 'order.dt search.dt', function () {
            $table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();


        $table.columns().every( function () {
            var that = this;
            $( 'input', this.header() ).on( 'keyup change', function () {

                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    };

    $(function() {
        datatableInit();
        $(".dataTables_filter input").attr("placeholder", "Ara...");
        $('#datatable-tabletools-kindergarten thead th').removeClass("sorting_asc");

    });

}).apply(this, [jQuery]);

(function($) {

    'use strict';

    var datatableInit = function() {
        var $table = $('#datatable-tabletools-kindergarten-ks').DataTable({
            "columnDefs": [ {
                "targets": [0, 1, 2, 3, 4, 5, 6, 7],
                "orderable": false
            }
            ],
            sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
            "language": {
                "sDecimal":        ",",
                "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
                "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                "sInfoEmpty":      "Kayıt yok",
                "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ".",
                "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
                "sLoadingRecords": "Yükleniyor...",
                "sProcessing":     "İşleniyor...",
                "sZeroRecords":    "Eşleşen kayıt bulunamadı",
                "searchPlaceholder": "Search records",
                "oPaginate": {
                    "sFirst":    "İlk",
                    "sLast":     "Son",
                    "sNext":     "Sonraki",
                    "sPrevious": "Önceki"
                },
                "oAria": {
                    "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                    "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
                }
            },
            oTableTools: {
                aButtons: [
//					{
//						sExtends: 'pdf',
//						sButtonText: 'PDF'
//					},
//					{
//						sExtends: 'csv',
//						sButtonText: 'CSV'
//					},
//					{
//						sExtends: 'xls',
//						sButtonText: 'Excel'
//					},
                    {
                        sExtends: 'print',
                        sButtonText: 'Yazdır',
                        sInfo: 'Çıktı almak için CTR+P basınız. Çıkmak için ESC tuşuna basınız.'
                    }
                ]
            }
        });
        //Sıraları yazdırır
        $table.on( 'order.dt search.dt', function () {
            $table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();


        $table.columns().every( function () {
            var that = this;
            $( 'input', this.header() ).on( 'keyup change', function () {

                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    };

    $(function() {
        datatableInit();
        $(".dataTables_filter input").attr("placeholder", "Ara...");
        $('#datatable-tabletools-kindergarten-ks thead th').removeClass("sorting_asc");

    });

}).apply(this, [jQuery]);

(function($) {

    'use strict';

    var datatableInit = function() {
        var $table = $('#datatable-tabletools-comment').DataTable({
            "columnDefs": [ {
                "targets": [0, 1, 2, 3, 4, 5, 6],
                "orderable": false
            }
            ],
            
            sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
            "language": {
                "sDecimal":        ",",
                "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
                "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                "sInfoEmpty":      "Kayıt yok",
                "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ".",
                "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
                "sLoadingRecords": "Yükleniyor...",
                "sProcessing":     "İşleniyor...",
                "sZeroRecords":    "Eşleşen kayıt bulunamadı",
                "searchPlaceholder": "Search records",
                "oPaginate": {
                    "sFirst":    "İlk",
                    "sLast":     "Son",
                    "sNext":     "Sonraki",
                    "sPrevious": "Önceki"
                },
                "oAria": {
                    "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                    "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
                }
            },
            oTableTools: {
                aButtons: [
//					{
//						sExtends: 'pdf',
//						sButtonText: 'PDF'
//					},
//					{
//						sExtends: 'csv',
//						sButtonText: 'CSV'
//					},
//					{
//						sExtends: 'xls',
//						sButtonText: 'Excel'
//					},
                    {
                        sExtends: 'print',
                        sButtonText: 'Yazdır',
                        sInfo: 'Çıktı almak için CTR+P basınız. Çıkmak için ESC tuşuna basınız.'
                    }
                ]
            }
        });
        //Sıraları yazdırır
        $table.on( 'order.dt search.dt', function () {
            $table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();


        $table.columns().every( function () {
            var that = this;
            $( 'input', this.header() ).on( 'keyup change', function () {

                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    };

    $(function() {
        datatableInit();
        $(".dataTables_filter input").attr("placeholder", "Ara...");
        $('#datatable-tabletools-comment thead th').removeClass("sorting_asc");

    });

}).apply(this, [jQuery]);

(function($) {

    'use strict';

    var datatableInit = function() {
        var $table = $('#datatable-tabletools-announcement').DataTable({
            "columnDefs": [ {
                "targets": [0, 1, 2, 3, 4, 5],
                "orderable": false
            }
            ],
            
            sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
            "language": {
                "sDecimal":        ",",
                "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
                "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                "sInfoEmpty":      "Kayıt yok",
                "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ".",
                "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
                "sLoadingRecords": "Yükleniyor...",
                "sProcessing":     "İşleniyor...",
                "sZeroRecords":    "Eşleşen kayıt bulunamadı",
                "searchPlaceholder": "Search records",
                "oPaginate": {
                    "sFirst":    "İlk",
                    "sLast":     "Son",
                    "sNext":     "Sonraki",
                    "sPrevious": "Önceki"
                },
                "oAria": {
                    "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                    "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
                }
            },
            oTableTools: {
                aButtons: [
//					{
//						sExtends: 'pdf',
//						sButtonText: 'PDF'
//					},
//					{
//						sExtends: 'csv',
//						sButtonText: 'CSV'
//					},
//					{
//						sExtends: 'xls',
//						sButtonText: 'Excel'
//					},
                    {
                        sExtends: 'print',
                        sButtonText: 'Yazdır',
                        sInfo: 'Çıktı almak için CTR+P basınız. Çıkmak için ESC tuşuna basınız.'
                    }
                ]
            }
        });
        //Sıraları yazdırır
        $table.on( 'order.dt search.dt', function () {
            $table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();


        $table.columns().every( function () {
            var that = this;
            $( 'input', this.header() ).on( 'keyup change', function () {

                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    };

    $(function() {
        datatableInit();
        $(".dataTables_filter input").attr("placeholder", "Ara...");
        $('#datatable-tabletools-announcement thead th').removeClass("sorting_asc");

    });

}).apply(this, [jQuery]);

(function($) {

    'use strict';

    var datatableInit = function() {
        var $table = $('#datatable-tabletools-payment').DataTable({
            "columnDefs": [ {
                "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8],
                "orderable": false
            }
            ],
            
            sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
            "language": {
                "sDecimal":        ",",
                "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
                "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                "sInfoEmpty":      "Kayıt yok",
                "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ".",
                "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
                "sLoadingRecords": "Yükleniyor...",
                "sProcessing":     "İşleniyor...",
                "sZeroRecords":    "Eşleşen kayıt bulunamadı",
                "searchPlaceholder": "Search records",
                "oPaginate": {
                    "sFirst":    "İlk",
                    "sLast":     "Son",
                    "sNext":     "Sonraki",
                    "sPrevious": "Önceki"
                },
                "oAria": {
                    "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                    "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
                }
            },
            oTableTools: {
                aButtons: [
//					{
//						sExtends: 'pdf',
//						sButtonText: 'PDF'
//					},
//					{
//						sExtends: 'csv',
//						sButtonText: 'CSV'
//					},
//					{
//						sExtends: 'xls',
//						sButtonText: 'Excel'
//					},
                    {
                        sExtends: 'print',
                        sButtonText: 'Yazdır',
                        sInfo: 'Çıktı almak için CTR+P basınız. Çıkmak için ESC tuşuna basınız.'
                    }
                ]
            }
        });
        //Sıraları yazdırır
        $table.on( 'order.dt search.dt', function () {
            $table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();


        $table.columns().every( function () {
            var that = this;
            $( 'input', this.header() ).on( 'keyup change', function () {

                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    };

    $(function() {
        datatableInit();
        $(".dataTables_filter input").attr("placeholder", "Ara...");
        $('#datatable-tabletools-payment thead th').removeClass("sorting_asc");

    });

}).apply(this, [jQuery]);

(function($) {

    'use strict';

    var datatableInit = function() {
        var $table = $('#datatable-tabletools-demand').DataTable({
            "columnDefs": [ {
                "targets": [0, 1, 2, 3, 4, 5],
                "orderable": false
            }
            ],
            
            sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
            "language": {
                "sDecimal":        ",",
                "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
                "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                "sInfoEmpty":      "Kayıt yok",
                "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ".",
                "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
                "sLoadingRecords": "Yükleniyor...",
                "sProcessing":     "İşleniyor...",
                "sZeroRecords":    "Eşleşen kayıt bulunamadı",
                "searchPlaceholder": "Search records",
                "oPaginate": {
                    "sFirst":    "İlk",
                    "sLast":     "Son",
                    "sNext":     "Sonraki",
                    "sPrevious": "Önceki"
                },
                "oAria": {
                    "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                    "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
                }
            },
            oTableTools: {
                aButtons: [
//					{
//						sExtends: 'pdf',
//						sButtonText: 'PDF'
//					},
//					{
//						sExtends: 'csv',
//						sButtonText: 'CSV'
//					},
//					{
//						sExtends: 'xls',
//						sButtonText: 'Excel'
//					},
                    {
                        sExtends: 'print',
                        sButtonText: 'Yazdır',
                        sInfo: 'Çıktı almak için CTR+P basınız. Çıkmak için ESC tuşuna basınız.'
                    }
                ]
            }
        });
        //Sıraları yazdırır
        $table.on( 'order.dt search.dt', function () {
            $table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();


        $table.columns().every( function () {
            var that = this;
            $( 'input', this.header() ).on( 'keyup change', function () {

                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    };

    $(function() {
        datatableInit();
        $(".dataTables_filter input").attr("placeholder", "Ara...");
        $('#datatable-tabletools-demand thead th').removeClass("sorting_asc");

    });

}).apply(this, [jQuery]);

(function($) {

    'use strict';

    var datatableInit = function() {
        var $table = $('#datatable-tabletools-demands').DataTable({
            "columnDefs": [ {
                "targets": [0, 1, 2, 3, 4, 5, 6, 7],
                "orderable": false
            }
            ],
            
            sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
            "language": {
                "sDecimal":        ",",
                "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
                "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                "sInfoEmpty":      "Kayıt yok",
                "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ".",
                "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
                "sLoadingRecords": "Yükleniyor...",
                "sProcessing":     "İşleniyor...",
                "sZeroRecords":    "Eşleşen kayıt bulunamadı",
                "searchPlaceholder": "Search records",
                "oPaginate": {
                    "sFirst":    "İlk",
                    "sLast":     "Son",
                    "sNext":     "Sonraki",
                    "sPrevious": "Önceki"
                },
                "oAria": {
                    "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                    "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
                }
            },
            oTableTools: {
                aButtons: [
//					{
//						sExtends: 'pdf',
//						sButtonText: 'PDF'
//					},
//					{
//						sExtends: 'csv',
//						sButtonText: 'CSV'
//					},
//					{
//						sExtends: 'xls',
//						sButtonText: 'Excel'
//					},
                    {
                        sExtends: 'print',
                        sButtonText: 'Yazdır',
                        sInfo: 'Çıktı almak için CTR+P basınız. Çıkmak için ESC tuşuna basınız.'
                    }
                ]
            }
        });
        //Sıraları yazdırır
        $table.on( 'order.dt search.dt', function () {
            $table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();


        $table.columns().every( function () {
            var that = this;
            $( 'input', this.header() ).on( 'keyup change', function () {

                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    };

    $(function() {
        datatableInit();
        $(".dataTables_filter input").attr("placeholder", "Ara...");
        $('#datatable-tabletools-demands thead th').removeClass("sorting_asc");

    });

}).apply(this, [jQuery]);

(function($) {

    'use strict';

    var datatableInit = function() {
        var $table = $('#datatable-tabletools-blogpost').DataTable({
            "columnDefs": [ {
                "targets": [0, 1, 2, 3, 4],
                "orderable": false
            }
            ],
            
            sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
            "language": {
                "sDecimal":        ",",
                "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
                "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                "sInfoEmpty":      "Kayıt yok",
                "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ".",
                "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
                "sLoadingRecords": "Yükleniyor...",
                "sProcessing":     "İşleniyor...",
                "sZeroRecords":    "Eşleşen kayıt bulunamadı",
                "searchPlaceholder": "Search records",
                "oPaginate": {
                    "sFirst":    "İlk",
                    "sLast":     "Son",
                    "sNext":     "Sonraki",
                    "sPrevious": "Önceki"
                },
                "oAria": {
                    "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                    "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
                }
            },
            oTableTools: {
                aButtons: [
//					{
//						sExtends: 'pdf',
//						sButtonText: 'PDF'
//					},
//					{
//						sExtends: 'csv',
//						sButtonText: 'CSV'
//					},
//					{
//						sExtends: 'xls',
//						sButtonText: 'Excel'
//					},
                    {
                        sExtends: 'print',
                        sButtonText: 'Yazdır',
                        sInfo: 'Çıktı almak için CTR+P basınız. Çıkmak için ESC tuşuna basınız.'
                    }
                ]
            }
        });
        //Sıraları yazdırır
        $table.on( 'order.dt search.dt', function () {
            $table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();


        $table.columns().every( function () {
            var that = this;
            $( 'input', this.header() ).on( 'keyup change', function () {

                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    };

    $(function() {
        datatableInit();
        $(".dataTables_filter input").attr("placeholder", "Ara...");
        $('#datatable-tabletools-blogpost thead th').removeClass("sorting_asc");

    });

}).apply(this, [jQuery]);

(function($) {

    'use strict';

    var datatableInit = function() {
        var $table = $('#datatable-tabletools-cat').DataTable({
            "columnDefs": [ {
                "targets": [0, 1, 2],
                "orderable": false
            }
            ],
            
            sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
            "language": {
                "sDecimal":        ",",
                "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
                "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                "sInfoEmpty":      "Kayıt yok",
                "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ".",
                "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
                "sLoadingRecords": "Yükleniyor...",
                "sProcessing":     "İşleniyor...",
                "sZeroRecords":    "Eşleşen kayıt bulunamadı",
                "searchPlaceholder": "Search records",
                "oPaginate": {
                    "sFirst":    "İlk",
                    "sLast":     "Son",
                    "sNext":     "Sonraki",
                    "sPrevious": "Önceki"
                },
                "oAria": {
                    "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                    "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
                }
            },
            oTableTools: {
                aButtons: [
//					{
//						sExtends: 'pdf',
//						sButtonText: 'PDF'
//					},
//					{
//						sExtends: 'csv',
//						sButtonText: 'CSV'
//					},
//					{
//						sExtends: 'xls',
//						sButtonText: 'Excel'
//					},
                    {
                        sExtends: 'print',
                        sButtonText: 'Yazdır',
                        sInfo: 'Çıktı almak için CTR+P basınız. Çıkmak için ESC tuşuna basınız.'
                    }
                ]
            }
        });
        //Sıraları yazdırır
        $table.on( 'order.dt search.dt', function () {
            $table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();


        $table.columns().every( function () {
            var that = this;
            $( 'input', this.header() ).on( 'keyup change', function () {

                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    };

    $(function() {
        datatableInit();
        $(".dataTables_filter input").attr("placeholder", "Ara...");
        $('#datatable-tabletools-cat thead th').removeClass("sorting_asc");

    });

}).apply(this, [jQuery]);

(function($) {

    'use strict';

    var datatableInit = function() {
        var $table = $('#datatable-tabletools-notification').DataTable({
            "columnDefs": [ {
                "targets": [0, 1, 2,3],
                "orderable": false
            }
            ],
            
            sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
            "language": {
                "sDecimal":        ",",
                "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
                "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                "sInfoEmpty":      "Kayıt yok",
                "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ".",
                "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
                "sLoadingRecords": "Yükleniyor...",
                "sProcessing":     "İşleniyor...",
                "sZeroRecords":    "Eşleşen kayıt bulunamadı",
                "searchPlaceholder": "Search records",
                "oPaginate": {
                    "sFirst":    "İlk",
                    "sLast":     "Son",
                    "sNext":     "Sonraki",
                    "sPrevious": "Önceki"
                },
                "oAria": {
                    "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                    "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
                }
            },
            oTableTools: {
                aButtons: [
//					{
//						sExtends: 'pdf',
//						sButtonText: 'PDF'
//					},
//					{
//						sExtends: 'csv',
//						sButtonText: 'CSV'
//					},
//					{
//						sExtends: 'xls',
//						sButtonText: 'Excel'
//					},
                    {
                        sExtends: 'print',
                        sButtonText: 'Yazdır',
                        sInfo: 'Çıktı almak için CTR+P basınız. Çıkmak için ESC tuşuna basınız.'
                    }
                ]
            }
        });
        //Sıraları yazdırır
        $table.on( 'order.dt search.dt', function () {
            $table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();


        $table.columns().every( function () {
            var that = this;
            $( 'input', this.header() ).on( 'keyup change', function () {

                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    };

    $(function() {
        datatableInit();
        $(".dataTables_filter input").attr("placeholder", "Ara...");
        $('#datatable-tabletools-notification thead th').removeClass("sorting_asc");

    });

}).apply(this, [jQuery]);

(function($) {

    'use strict';

    var datatableInit = function() {
        var $table = $('#datatable-tabletools-gallery').DataTable({
            "columnDefs": [ {
                "targets": [0, 1, 2,3, 4],
                "orderable": false
            }
            ],
            
            sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
            "language": {
                "sDecimal":        ",",
                "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
                "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                "sInfoEmpty":      "Kayıt yok",
                "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ".",
                "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
                "sLoadingRecords": "Yükleniyor...",
                "sProcessing":     "İşleniyor...",
                "sZeroRecords":    "Eşleşen kayıt bulunamadı",
                "searchPlaceholder": "Search records",
                "oPaginate": {
                    "sFirst":    "İlk",
                    "sLast":     "Son",
                    "sNext":     "Sonraki",
                    "sPrevious": "Önceki"
                },
                "oAria": {
                    "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                    "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
                }
            },
            oTableTools: {
                aButtons: [
//					{
//						sExtends: 'pdf',
//						sButtonText: 'PDF'
//					},
//					{
//						sExtends: 'csv',
//						sButtonText: 'CSV'
//					},
//					{
//						sExtends: 'xls',
//						sButtonText: 'Excel'
//					},
                    {
                        sExtends: 'print',
                        sButtonText: 'Yazdır',
                        sInfo: 'Çıktı almak için CTR+P basınız. Çıkmak için ESC tuşuna basınız.'
                    }
                ]
            }
        });
        //Sıraları yazdırır
        $table.on( 'order.dt search.dt', function () {
            $table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();


        $table.columns().every( function () {
            var that = this;
            $( 'input', this.header() ).on( 'keyup change', function () {

                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    };

    $(function() {
        datatableInit();
        $(".dataTables_filter input").attr("placeholder", "Ara...");
        $('#datatable-tabletools-gallery thead th').removeClass("sorting_asc");

    });

}).apply(this, [jQuery]);


(function($) {

    'use strict';

    var datatableInit = function() {
        var $table = $('#datatable-tabletools-demand-spesific').DataTable({
            "columnDefs": [ {
                "targets": [0, 1, 2,3, 4,5],
                "orderable": false
            }
            ],

            sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
            "language": {
                "sDecimal":        ",",
                "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
                "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                "sInfoEmpty":      "Kayıt yok",
                "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ".",
                "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
                "sLoadingRecords": "Yükleniyor...",
                "sProcessing":     "İşleniyor...",
                "sZeroRecords":    "Eşleşen kayıt bulunamadı",
                "searchPlaceholder": "Search records",
                "oPaginate": {
                    "sFirst":    "İlk",
                    "sLast":     "Son",
                    "sNext":     "Sonraki",
                    "sPrevious": "Önceki"
                },
                "oAria": {
                    "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                    "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
                }
            },
            oTableTools: {
                aButtons: [
//					{
//						sExtends: 'pdf',
//						sButtonText: 'PDF'
//					},
//					{
//						sExtends: 'csv',
//						sButtonText: 'CSV'
//					},
//					{
//						sExtends: 'xls',
//						sButtonText: 'Excel'
//					},
                    {
                        sExtends: 'print',
                        sButtonText: 'Yazdır',
                        sInfo: 'Çıktı almak için CTR+P basınız. Çıkmak için ESC tuşuna basınız.'
                    }
                ]
            }
        });
        //Sıraları yazdırır
        $table.on( 'order.dt search.dt', function () {
            $table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();


        $table.columns().every( function () {
            var that = this;
            $( 'input', this.header() ).on( 'keyup change', function () {

                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    };

    $(function() {
        datatableInit();
        $(".dataTables_filter input").attr("placeholder", "Ara...");
        $('#datatable-tabletools-demand-spesific thead th').removeClass("sorting_asc");

    });

}).apply(this, [jQuery]);


(function($) {

    'use strict';

    var datatableInit = function() {
        var $table = $('#datatable-tabletools-sss').DataTable({
            "columnDefs": [ {
                "targets": [0, 1, 2, 3, 4,5],
                "orderable": false
            }
            ],
            
            sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
            "language": {
                "sDecimal":        ",",
                "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
                "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                "sInfoEmpty":      "Kayıt yok",
                "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ".",
                "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
                "sLoadingRecords": "Yükleniyor...",
                "sProcessing":     "İşleniyor...",
                "sZeroRecords":    "Eşleşen kayıt bulunamadı",
                "searchPlaceholder": "Search records",
                "oPaginate": {
                    "sFirst":    "İlk",
                    "sLast":     "Son",
                    "sNext":     "Sonraki",
                    "sPrevious": "Önceki"
                },
                "oAria": {
                    "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                    "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
                }
            },
            oTableTools: {
                aButtons: [
//					{
//						sExtends: 'pdf',
//						sButtonText: 'PDF'
//					},
//					{
//						sExtends: 'csv',
//						sButtonText: 'CSV'
//					},
//					{
//						sExtends: 'xls',
//						sButtonText: 'Excel'
//					},
                    {
                        sExtends: 'print',
                        sButtonText: 'Yazdır',
                        sInfo: 'Çıktı almak için CTR+P basınız. Çıkmak için ESC tuşuna basınız.'
                    }
                ]
            }
        });
        //Sıraları yazdırır
        $table.on( 'order.dt search.dt', function () {
            $table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();


        $table.columns().every( function () {
            var that = this;
            $( 'input', this.header() ).on( 'keyup change', function () {

                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    };

    $(function() {
        datatableInit();
        $(".dataTables_filter input").attr("placeholder", "Ara...");
        $('#datatable-tabletools-cat thead th').removeClass("sorting_asc");

    });

}).apply(this, [jQuery]);

(function($) {

    'use strict';

    var datatableInit = function() {
        var $table = $('#datatable-tabletools-2').DataTable({
            "columnDefs": [ {
                "targets": [0, -1],
                "orderable": false
            }
            ],
            
            sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
            "language": {
                "sDecimal":        ",",
                "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
                "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                "sInfoEmpty":      "Kayıt yok",
                "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ".",
                "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
                "sLoadingRecords": "Yükleniyor...",
                "sProcessing":     "İşleniyor...",
                "sZeroRecords":    "Eşleşen kayıt bulunamadı",
                "searchPlaceholder": "Search records",
                "oPaginate": {
                    "sFirst":    "İlk",
                    "sLast":     "Son",
                    "sNext":     "Sonraki",
                    "sPrevious": "Önceki"
                },
                "oAria": {
                    "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                    "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
                }
            },
            oTableTools: {
                aButtons: [
//					{
//						sExtends: 'pdf',
//						sButtonText: 'PDF'
//					},
//					{
//						sExtends: 'csv',
//						sButtonText: 'CSV'
//					},
//					{
//						sExtends: 'xls',
//						sButtonText: 'Excel'
//					},
                    {
                        sExtends: 'print',
                        sButtonText: 'Yazdır',
                        sInfo: 'Çıktı almak için CTR+P basınız. Çıkmak için ESC tuşuna basınız.'
                    }
                ]
            }
        });
        //Sıraları yazdırır
        $table.on( 'order.dt search.dt', function () {
            $table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    };

    $(function() {
        datatableInit();
        $(".dataTables_filter input").attr("placeholder", "Ara...");

    });

}).apply(this, [jQuery]);


(function($) {

	'use strict';

	var datatableInit = function() {
    var $table = $('#datatable-tabletools-news').DataTable({
        "columnDefs": [ {
                            "targets": [0, -1],
                            "orderable": false
                        }
                    ],
        'processing': true,
        'serverSide': true,

         xhrFields: {
              withCredentials: true
         },
        "ajax": {
           "url" : "ajaxrequest/news",
           "type": "POST"
         },
        'columns': [
           { data: 'ind', "class" : "td-middle" },
           { data: 'baslik', "class" : "td-middle" },
           { data: 'aciklama', "class" : "td-middle" },
           { data: 'yayin_tarihi', "class" : "td-middle" },
           { data: 'author_id', "class" : "td-middle" },
           { data: 'sira', "class" : "td-middle" },
           { data: 'islemler', "class" : "center" }
        ],
        
        sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
        "language": {
            "sDecimal":        ",",
            "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
            "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
            "sInfoEmpty":      "Kayıt yok",
            "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
            "sInfoPostFix":    "",
            "sInfoThousands":  ".",
            "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
            "sLoadingRecords": "Yükleniyor...",
            "sProcessing":     "İşleniyor...",
            "sZeroRecords":    "Eşleşen kayıt bulunamadı",
            "sSearchPlaceholder": "Search",
            "oPaginate": {
                "sFirst":    "İlk",
                "sLast":     "Son",
                "sNext":     "Sonraki",
                "sPrevious": "Önceki"
            },
            "oAria": {
                "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
            },               
        oTableTools: {
                aButtons: [
//					{
//						sExtends: 'pdf',
//						sButtonText: 'PDF'
//					},
//					{
//						sExtends: 'csv',
//						sButtonText: 'CSV'
//					},
//					{
//						sExtends: 'xls',
//						sButtonText: 'Excel'
//					},
                        {
                                sExtends: 'print',
                                sButtonText: 'Yazdır',
                                sInfo: 'Çıktı almak için CTR+P basınız. Çıkmak için ESC tuşuna basınız.'
                        }
                ]
        }
        }
   });
};

	$(function() {
		datatableInit();
                $(".dataTables_filter input").attr("placeholder", "Ara...");
                
	});

}).apply(this, [jQuery]);




$(document).ready(function(){
    var $table = $('#datatable-tabletools-post').DataTable({
        "columnDefs": [ {
                            "targets": [0, -1],
                            "orderable": false
                        }
                    ],
        'processing': true,
        'serverSide': true,

         xhrFields: {
              withCredentials: true
         },
        "ajax": {
           "url" : "ajaxrequest/posts",
           "type": "POST"
         },
        'columns': [
           { data: 'ind', "class" : "td-middle" },
           { data: 'baslik', "class" : "td-middle" },
           { data: 'aciklama', "class" : "td-middle" },
           { data: 'yayin_tarihi', "class" : "td-middle" },
           { data: 'author_id', "class" : "td-middle" },
           { data: 'sira', "class" : "td-middle" },
           { data: 'islemler', "class" : "center" }
        ],
        
        sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
        "language": {
            "sDecimal":        ",",
            "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
            "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
            "sInfoEmpty":      "Kayıt yok",
            "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
            "sInfoPostFix":    "",
            "sInfoThousands":  ".",
            "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
            "sLoadingRecords": "Yükleniyor...",
            "sProcessing":     "İşleniyor...",
            "sZeroRecords":    "Eşleşen kayıt bulunamadı",
            "sSearchPlaceholder": "Search",
            "oPaginate": {
                "sFirst":    "İlk",
                "sLast":     "Son",
                "sNext":     "Sonraki",
                "sPrevious": "Önceki"
            },
            "oAria": {
                "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
            },               
        oTableTools: {
                aButtons: [
//					{
//						sExtends: 'pdf',
//						sButtonText: 'PDF'
//					},
//					{
//						sExtends: 'csv',
//						sButtonText: 'CSV'
//					},
//					{
//						sExtends: 'xls',
//						sButtonText: 'Excel'
//					},
                        {
                                sExtends: 'print',
                                sButtonText: 'Yazdır',
                                sInfo: 'Çıktı almak için CTR+P basınız. Çıkmak için ESC tuşuna basınız.'
                        }
                ]
        }
        }
   });
              
       
});


$(document).ready(function(){
    var $table = $('#datatable-tabletools-agenda').DataTable({
        "columnDefs": [ {
                            "targets": [0, -1],
                            "orderable": false
                        }
                    ],
        'processing': true,
        'serverSide': true,

         xhrFields: {
              withCredentials: true
         },
        "ajax": {
           "url" : "ajaxrequest/agenda",
           "type": "POST"
            
         },
        'columns': [
           { data: 'ind', "class" : "td-middle" },
           { data: 'baslik', "class" : "td-middle" },
           { data: 'aciklama', "class" : "td-middle" },
           { data: 'yayin_tarihi', "class" : "td-middle" },
           { data: 'author_id', "class" : "td-middle" },
           { data: 'sira', "class" : "td-middle" },
           { data: 'islemler', "class" : "center" }
        ],
        
        sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
        "language": {
            "sDecimal":        ",",
            "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
            "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
            "sInfoEmpty":      "Kayıt yok",
            "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
            "sInfoPostFix":    "",
            "sInfoThousands":  ".",
            "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
            "sLoadingRecords": "Yükleniyor...",
            "sProcessing":     "İşleniyor...",
            "sZeroRecords":    "Eşleşen kayıt bulunamadı",
            "sSearchPlaceholder": "Search",
            "oPaginate": {
                "sFirst":    "İlk",
                "sLast":     "Son",
                "sNext":     "Sonraki",
                "sPrevious": "Önceki"
            },
            "oAria": {
                "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
            },               
        oTableTools: {
                aButtons: [
//					{
//						sExtends: 'pdf',
//						sButtonText: 'PDF'
//					},
//					{
//						sExtends: 'csv',
//						sButtonText: 'CSV'
//					},
//					{
//						sExtends: 'xls',
//						sButtonText: 'Excel'
//					},
                        {
                                sExtends: 'print',
                                sButtonText: 'Yazdır',
                                sInfo: 'Çıktı almak için CTR+P basınız. Çıkmak için ESC tuşuna basınız.'
                        }
                ]
        }
        }
   });
         
});


(function($) {

	'use strict';

	var datatableInit = function() {
    var $table = $('#datatable-tabletools-author').DataTable({
        "columnDefs": [ {
                            "targets": [0, -1],
                            "orderable": false
                        }
                    ],
        'processing': true,
        'serverSide': true,

         xhrFields: {
              withCredentials: true
         },
        "ajax": {
           "url" : "ajaxrequest/authors",
           "type": "POST"
         },
        'columns': [
           { data: 'ind', "class" : "td-middle" },
           { data: 'name', "class" : "td-middle" },
           { data: 'city', "class" : "td-middle" },
           { data: 'fotograf', "class" : "td-middle center" },
           { data: 'count_author', "class" : "td-middle" },
           { data: 'islemler', "class" : "td-middle center" }
        ],
        
        sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
        "language": {
            "sDecimal":        ",",
            "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
            "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
            "sInfoEmpty":      "Kayıt yok",
            "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
            "sInfoPostFix":    "",
            "sInfoThousands":  ".",
            "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
            "sLoadingRecords": "Yükleniyor...",
            "sProcessing":     "İşleniyor...",
            "sZeroRecords":    "Eşleşen kayıt bulunamadı",
            "sSearchPlaceholder": "Search",
            "oPaginate": {
                "sFirst":    "İlk",
                "sLast":     "Son",
                "sNext":     "Sonraki",
                "sPrevious": "Önceki"
            },
            "oAria": {
                "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
            },               
        oTableTools: {
                aButtons: [
//					{
//						sExtends: 'pdf',
//						sButtonText: 'PDF'
//					},
//					{
//						sExtends: 'csv',
//						sButtonText: 'CSV'
//					},
//					{
//						sExtends: 'xls',
//						sButtonText: 'Excel'
//					},
                        {
                                sExtends: 'print',
                                sButtonText: 'Yazdır',
                                sInfo: 'Çıktı almak için CTR+P basınız. Çıkmak için ESC tuşuna basınız.'
                        }
                ]
        }
        }
   });
};

	$(function() {
		datatableInit();
                $(".dataTables_filter input").attr("placeholder", "Ara...");
                
	});

}).apply(this, [jQuery]);



