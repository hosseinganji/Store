<div class="col-12 pb-1">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <div class="btn-group">
                <select id="sort-select" class="form-control border-0" onchange="filter_slidbar()">
                    <option value="delete" {{ request("sorting") == "delete" ? "selected" : "" }}>مرتب سازی</option>
                    <option value="max" {{ request("sorting") == "max" ? "selected" : "" }}>بیشترین قیمت</option>
                    <option value="min" {{ request("sorting") == "min" ? "selected" : "" }}>کمترین قیمت</option>
                    <option value="newest" {{ request("sorting") == "newest" ? "selected" : "" }}>جدید ترین</option>
                    <option value="latest" {{ request("sorting") == "latest" ? "selected" : "" }}>قدیمی ترین</option>
                </select>
            </div>
        </div>
        <div class="ml-2">
            <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
            <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
        </div>
    </div>
</div>
