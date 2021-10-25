{{-- <html>	
	<head>
		<title>Product Stock Barcodes</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	</head>
	<h1 class="text-primary" style="text-align: center;margin-bottom: 20px;">Product Stock Barcodes</h1>
    <div style="text-align: center;">
        <div class="container">
            
@foreach(App\Model\Warehouse\InvoiceDetailGradeProduct::limit(15)->get() as $item)
          
            <div class="row"> 
            <div class="col-sm-12 p-1 " style=" width:67mm; border: 1px solid red; margin-bottom:2mm">
                <div style="width: 15mm">
                </div>
                <div class="row"  style="width: 37mm"> 
                    <div class="col" style="height: 14mm">
                        <span >Gin {{ $item->iname ?? 'Alias' }}</span><br>
<span>Gin {{ $item->width ?? 'Alias' }}</span><br>
<span>Gin {{ $item->depth ?? 'Alias' }}</span><br>
</div>
<div class="col" style="height: 14mm">
    <span>Gin {{ $item->grade->grade ?? 'Alias' }}</span> <br>
    <span>Gin {{ $item->grade->grade ?? 'Alias' }}</span> <br>
</div>
</div>
<div style="width: 15mm">
</div>

<img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($item->gin, 'C128A') }}"
    alt="barcode" style="width:37mm" />

<h3 style="margin-top: 2px">Gin {{ $item->gin }}</h3>
</div>
</div>
@endforeach
</div>

<img src="data:image/png;base64,{{ DNS1D::getBarcodePNG('11', 'C39') }}"
    alt="barcode" /><br><br>
<img src="data:image/png;base64,{{ DNS1D::getBarcodePNG('123456789', 'C39+',1,33,array(0,255,0), true) }}"
    alt="barcode" /><br><br>
<img src="data:image/png;base64,{{ DNS1D::getBarcodePNG('4', 'C39+',3,33,array(255,0,0)) }}"
    alt="barcode" /><br><br>
<img src="data:image/png;base64,{{ DNS1D::getBarcodePNG('12', 'C39+') }}"
    alt="barcode" /><br><br>
<img src="data:image/png;base64,{{ DNS1D::getBarcodePNG('23', 'POSTNET') }}"
    alt="barcode" /><br /><br />
</div>

</html> --}}
{{-- @foreach (App\Model\Warehouse\InvoiceDetailGradeProduct::limit(15)->get() as $item) --}}


<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"
        integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw=="
        crossorigin="anonymous"></script>
    <style>
        .num {
            width: 67mm;
            height: 28mm;
            margin-bottom: 2mm;

        }

        .con {
            height: 14mm;
            width: 37mm;
            margin-left: 15mm;
            margin-right: 15mm;
            font-size: 9px;
            padding: 0px;
        }

        .stu {

            height: 4mm;
            width: 37mm;
            margin-right: 15mm;
            margin-left: 15mm;
            font-size: 9px;
            padding: 0px;

        }

        .con1 {
            height: 10mm;
            width: 37mm;
            margin-left: 15mm;
            margin-right: 15mm;

            font-size: 7px;
            padding: 0px;
        }

    </style>
</head>

<body>

    @foreach($items as $item)


        <div class="container num border border-dark">
            <div class="row">
                <div class="col-lg-12 con border border-dark">
                    <div class="row">
                        <label>{{ $item->iname ?? "" }}</label><br>

                        <div class="col-lg-2 ">
                            <label>Length:</label>
                            <label>Weight:</label>
                            <label>Big:</label>
                        </div>

                        <div class="col-lg-2 ">
                            <label class="offset-10">{{ $item->length }}mm</label>
                            <label class="offset-10">{{ $item->weight }}mm</label>
                            <label>{{ $item->ratti->rati_big }}+</label>
                        </div>

                        <div class="col-lg-1"></div>

                        <div class="col-lg-2 ">
                            <label>Width:</label>
                            <label>Depth:</label>
                            <label>Standard:</label>
                        </div>

                        <div class="col-lg-3 ">
                            <label>{{ $item->width }}mm</label>
                            <label>{{ $item->depth }}</label>
                            <label class="offset-10">{{ $item->ratti->rati_standard }}+</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 stu border border-dark d-flex">
                    <label>MRP-</label>
                    <span>Rs12,00</span>
                    <label class="offset-1">C-</label>
                    <span>12mg</span>
                    <label class="offset-1">-</label>
                    <span>13,000</span>
                </div>
                <div class="col-lg-12 con1 border border-dark">
                    <div class="col-md-2 d-inline-block offset-4 fa-2x mt-3">
                        <label>G</label>
                    </div>
                    <div class="col-md-6 float-end ">
                        <label><img
                                src="data:image/png;base64,{{ DNS1D::getBarcodePNG($item->gin, 'C128A') }}"
                                height="23px" width="60px"><br>

                            <label class="text-right  offset-1">{{ $item->gin }}</label>
                    </div>
                </div>

            </div>
        </div>
    @endforeach


</body>

</html>
