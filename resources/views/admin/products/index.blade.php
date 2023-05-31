@extends('layouts.app')


@section('title')
    Product
@endsection

@section('script')
@endsection

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">محصول ({{ $products->total() }})</h1>
        <a class="btn btn-primary ml-3" href="{{ route('admin.products.create') }}">ایجاد محصول</a>
    </div>
    <div id="myGrid" class="ag-theme-alpine" style="height: 500px; font-family: iransans;"></div>

    <script>
        class ShowProduct {
            init(params) {
                this.eGui = document.createElement('div');
                this.eGui.innerHTML = `
                        <span>
                            <a href="{{ url('/admin-panel/management/products/') }}/${params["data"]["id"]}" class="btn-simple fw-bold">${params["data"]["name"]}</a>
                        </span>
                    `;
                this.eButton = this.eGui.querySelector('.btn-simple');
                this.cellValue = this.getValueToDisplay(params);
                this.eButton.addEventListener('click', this.eventListener);
            }

            getGui() {
                return this.eGui;
            }

            refresh(params) {
                this.cellValue = this.getValueToDisplay(params);
                this.eValue.innerHTML = this.cellValue;
                return true;
            }

            destroy() {
                if (this.eButton) {
                    this.eButton.removeEventListener('click', this.eventListener);
                }
            }

            getValueToDisplay(params) {
                return params.valueFormatted ? params.valueFormatted : params.value;
            }
        }

        class EditProduct {
            init(params) {
                this.eGui = document.createElement('div');
                this.eGui.innerHTML = `
                        <div class="d-flex justify-content-around">
                            <a href="{{ url('/admin-panel/management/products/') }}/${params["data"]["id"]}/edit" class="btn-simple text-success" style="margin-top: 4px;">
                                <i class="fa fa-pencil-square-o fs-5" aria-hidden="true"></i>    
                            </a>
                            <form
                                action="{{ url('/admin-panel/management/products/') }}/${params["data"]["id"]}"
                                method="POST"  style="margin-top: 2px;">
                                @csrf
                                @method('delete')
                                <button
                                    onclick="return confirm('آیا از حذف کردن این آیتم مطمئن هستید؟');"
                                    class="border-0 bg-transparent" type="submit">
                                    <i class="fa fa-trash fs-5 text-danger" aria-hidden="true"></i>
                                </button>
                            </form>
                        </div>
                    `;
                this.eButton = this.eGui.querySelector('.btn-simple');
                this.cellValue = this.getValueToDisplay(params);
                this.eButton.addEventListener('click', this.eventListener);
            }

            getGui() {
                return this.eGui;
            }

            refresh(params) {
                this.cellValue = this.getValueToDisplay(params);
                this.eValue.innerHTML = this.cellValue;
                return true;
            }

            destroy() {
                if (this.eButton) {
                    this.eButton.removeEventListener('click', this.eventListener);
                }
            }

            getValueToDisplay(params) {
                return params.valueFormatted ? params.valueFormatted : params.value;
            }
        }

        class CustomStatsToolPanel {
            init(params) {
                this.eGui = document.createElement('div');
                this.eGui.style.textAlign = "center";

                // calculate stats when new rows loaded, i.e. onModelUpdated
                const renderStats = () => {
                    this.eGui.innerHTML = this.calculateStats(params);
                };
                params.api.addEventListener('modelUpdated', renderStats);
            }

            getGui() {
                return this.eGui;
            }
        }


        function onCellEditRequest(event) {
            console.log(event.newValue);
            console.log(event.oldValue);
            console.log(event.data);
            console.log(event);
            console.log(event.column.colId);
        }

        function onFirstDataRendered(params) {
            params.api.sizeColumnsToFit();
        }

        const gridOptions = {
            suppressMenuHide: true,
            enableRtl: true,
            // onFirstDataRendered: onFirstDataRendered,
            readOnlyEdit: true,
            onCellEditRequest: onCellEditRequest,
            sideBar: {
                toolPanels: [{
                        id: 'columns',
                        labelDefault: 'ستونها',
                        labelKey: 'columns',
                        iconKey: 'columns',
                        toolPanel: 'agColumnsToolPanel',
                    },
                    {
                        id: 'filters',
                        labelDefault: 'فیلتر ها ',
                        labelKey: 'filters',
                        iconKey: 'filter',
                        toolPanel: 'agFiltersToolPanel',
                    },
                ],
            },

            columnDefs: [{
                    headerName: "#",
                    field: 'id',
                    sortable: true,
                    maxWidth: 105,
                    editable: false,
                }, {
                    headerName: "نام",
                    field: 'name',
                    cellRenderer: ShowProduct,
                    sortable: true,
                }, {
                    headerName: "sku",
                    field: 'sku',
                }, {
                    headerName: "نام دسته بندی",
                    field: 'category_name',
                }, {
                    headerName: "برند",
                    field: 'brand',
                }, {
                    headerName: "تگ ها",
                    field: 'tags',
                }, {
                    headerName: "ویژگی ها",
                    field: 'variations',
                    minWidth: 300,
                },
                {
                    headerName: 'ویژگی های متغیر',
                    groupId: 'medalsGroup',
                    children: [
                        {
                            headerName: 'ویژگی متغیر',
                            field: 'variation_attribute',
                            type: 'medalColumn',
                            columnGroupShow: 'opened',
                            minWidth: 170,
                        },
                        {
                            headerName: 'نام',
                            field: 'variation_name',
                            type: 'medalColumn',
                        },
                        {
                            headerName: 'قیمت',
                            field: 'variation_price',
                            type: 'medalColumn',
                        },
                        {
                            headerName: 'تعداد',
                            field: 'variation_quantity',
                            type: 'medalColumn',
                        },
                        {
                            headerName: 'شناسه ویژگی',
                            field: 'variation_sku',
                            type: 'medalColumn',
                        },
                        
                    ],
                },



                {
                    headerName: "وضعیت",
                    field: 'status',
                    cellStyle: params => {
                        if (params.value === 'فعال') {
                            return {
                                color: 'green',
                                fontWeight: 'bold',
                            };
                        } else {
                            return {
                                color: 'red',
                                fontWeight: 'bold',
                            };
                        }
                    }
                }, {
                    headerName: "هزینه ارسال",
                    field: 'send_price',
                }, {
                    headerName: "هزینه ارسال به ازای محصول اضافی",
                    field: 'send_price_per_extra_product',
                    cellStyle: params => {
                        if (params.value === 'رایگان') {
                            return {
                                color: 'green',
                                fontWeight: 'bold',
                            };
                        }
                    }
                }, {
                    headerName: "عملیات",
                    field: 'operation',
                    floatingFilter: false,
                    cellRenderer: EditProduct,
                    maxWidth: 150,
                    resizable: false,
                    editable: false,
                },
            ],

            defaultColDef: {
                width: 150,
                editable: true,
                filter: 'agTextColumnFilter',
                floatingFilter: true,
                resizable: true,
                enableValue: true,
                enableRowGroup: true,
                enablePivot: true,
                sortable: true,
            },
            defaultColGroupDef: {
                marryChildren: true,
            },

            // define specific column types
            columnTypes: {
                numberColumn: {
                    width: 130,
                    filter: 'agNumberColumnFilter'
                },
                medalColumn: {
                    width: 100,
                    columnGroupShow: 'open',
                    filter: false
                },
                nonEditableColumn: {
                    editable: false
                },
                dateColumn: {
                    // specify we want to use the date filter
                    filter: 'agDateColumnFilter',

                    // add extra parameters for the date filter
                    filterParams: {
                        // provide comparator function
                        comparator: (filterLocalDateAtMidnight, cellValue) => {
                            // In the example application, dates are stored as dd/mm/yyyy
                            // We create a Date object for comparison against the filter date
                            const dateParts = cellValue.split('/');
                            const day = Number(dateParts[0]);
                            const month = Number(dateParts[1]) - 1;
                            const year = Number(dateParts[2]);
                            const cellDate = new Date(year, month, day);

                            // Now that both parameters are Date objects, we can compare
                            if (cellDate < filterLocalDateAtMidnight) {
                                return -1;
                            } else if (cellDate > filterLocalDateAtMidnight) {
                                return 1;
                            } else {
                                return 0;
                            }
                        },
                    },
                },
            },

            rowData: JSON.parse(`{{ $product_json }}`.replace(/&quot;/g, '"'))
        };

        console.log(JSON.parse(`{{ $product_json }}`.replace(/&quot;/g, '"')));

        document.addEventListener('DOMContentLoaded', () => {
            const gridDiv = document.querySelector('#myGrid');
            new agGrid.Grid(gridDiv, gridOptions);
        });
    </script>
@endsection
