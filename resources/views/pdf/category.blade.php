<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ public_path('report-style/category.css') }}">

</head>
<body>
    <section class="invoice">
        <!-- title row -->
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-2 invoice-col">
            </div>
            <!-- /.col -->
            <div class="col-sm-8 invoice-col">
               <h5>IRPC TECHNOLOGY COLLEGE</h5>
            </div>
            <!-- /.col -->
            <div class="col-sm-2 invoice-col">

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <br/>
        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped" width="100%">
                    <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Category Code</th>
                        <th width="30%">Category Name</th>
                        <th width="15%">Asset</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td class="text-center">{{ $category->category_code }}</td>
                        <td>{{ $category->category_name }}</td>
                        <td>1000</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
                <p class="lead" style="font-family: Helvetica Neue">Payment Methods:</p>
                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                    sfsdfgsdfg
                </p>
            </div>
            <!-- /.col -->
            <div class="col-xs-6">
                <div>
                    <table>
                        <tbody><tr>
                            <th style="width:50%;text-align: right">Total:</th>
                            <td>10100</td>
                        </tr>
                        <tr>
                            <th style="text-align: right">Tips:</th>
                            <td>khmer</td>
                        </tr>
                        <tr>
                            <th style="text-align: right">Total with Tips:</th>
                            <td>fadfadsf</td>
                        </tr>
                        <tr>
                            <th style="text-align: right">Loan:</th>
                            <td>fssfsdfg</td>
                        </tr>
                        <tr>
                            <th style="text-align: right">Total Paid:</th>
                            <td>fsgfsfdg</td>
                        </tr>
                        <tr>
                            <th></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th style="text-align: right">Paid By:</th>
                            <td>fsgfdgsdfgdf</td>
                        </tr>
                        </tbody></table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <br/>
        <br/>
        <div class="row">
            <div class="col-xs-4"></div>
            <div class="col-xs-4">
                <span class="lead">Receipt Date: 2020</span>
            </div>
            <div class="col-xs-4"></div>
        </div>
        <div class="row">
            <div class="col-xs-4"></div>
            <div class="col-xs-4">
                <span class="lead">Recipient: </span>
            </div>
            <div class="col-xs-4"></div>
        </div>
        <!-- /.row -->
    </section>

</body>
</html>
