<!-- Shop Sidebar Start -->
<div class="col-lg-3 col-md-3">
    <form id="form-filter">
        <!-- Attributes Start -->
        @foreach ($attributes as $attribute)
            <h5 class="section-title position-relative text-right text-uppercase mb-3">
                <span class="bg-secondary pl-3 fw-bold">{{ $attribute->name }}</span>
            </h5>
            <div class="bg-light p-4 mb-30">
                @foreach ($attribute->attributeValue as $attrVal)
                    <div
                        class="custom-control custom-checkbox d-flex align-items-center pl-0 pr-4 justify-content-between mb-3">
                        <input type="checkbox" class="attribute_input_original_{{ $attribute->id }} custom-control-input"
                            value="{{ $attrVal->value }}"
                            id="attribute-{{ $attribute->id }}-{{ $attrVal->value }}-{{ $attrVal->attribute_id }}"
                            onchange="filter_slidbar()"
                            {{ request()->has('attribute.' . $attribute->id) && in_array($attrVal->value, explode('-', request()->attribute[$attribute->id])) ? 'checked' : '' }}
                            >
                        <label class="custom-control-label"
                            for="attribute-{{ $attribute->id }}-{{ $attrVal->value }}-{{ $attrVal->attribute_id }}">
                            {{ $attrVal->value }}
                        </label>
                        <span class="badge border font-weight-normal text-dark">1000</span>
                    </div>
                @endforeach

            </div>
        @endforeach
        <!-- Attributes End -->

        <!-- Variation Start -->

        <h5 class="section-title position-relative text-right text-uppercase mb-3">
            <span class="bg-secondary pl-3 fw-bold">{{ $variations->name }}</span>
        </h5>
        <div class="bg-light p-4 mb-30">
            @foreach ($variations->variationValue as $varVal)
                <div
                    class="custom-control custom-checkbox d-flex align-items-center pl-0 pr-4 justify-content-between mb-3">
                    <input type="checkbox" class="filter_input_original custom-control-input"
                        value="{{ $varVal->value }}"
                        id="variation-{{ $variations->name }}-{{ $varVal->value }}-{{ $varVal->attribute_id }}"
                        onchange="filter_slidbar()"
                        {{ request()->has('variation') && in_array($varVal->value, explode('-', request('variation'))) ? 'checked' : '' }}>

                    <label class="custom-control-label"
                        for="variation-{{ $variations->name }}-{{ $varVal->value }}-{{ $varVal->attribute_id }}">
                        {{ $varVal->value }}
                    </label>
                    <span class="badge border font-weight-normal text-dark">1000</span>
                </div>
            @endforeach
        </div>

        @foreach ($attributes as $attribute)
            <input type="hidden" name="attribute[{{ $attribute->id }}]"
                id="attribute_input_hidden_{{ $attribute->id }}">
        @endforeach

        <input type="hidden" name="variation" id="filter_input_hidden">

        <input type="hidden" id="sort-input" name="sorting">
        <!-- Variation End -->
    </form>
</div>
<!-- Shop Sidebar End -->


<style>
    .custom-control-label::after,
    .custom-control-label::before {
        right: -1.9rem;
        top: 0.15rem;
    }
</style>
