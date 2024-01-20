<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route("products.index")}}"><i class="fa fa-table"></i> الاصناف</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route("customers.index")}}"><i class="fa fa-users"></i> العملاء</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route("invoices.index")}}"><i class="fa fa-file-invoice-dollar"></i> الفواتير</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
