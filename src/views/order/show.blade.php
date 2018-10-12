<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">{!! trans('order.show_order') !!}</h4>
</div>
<div class="modal-body allcp-form">
    <div class="clearfix">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>{!! trans('order.popup_name') !!}</th>
                <th>{!! trans('order.popup_value') !!}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <label>
                        <h6 class="mb5 mt10"> {{trans('taxonomy.cat_bp')}}</h6>
                    </label>
                </td>
                <td>
                    {!! (isset($data->part->name) && $data->part->name ? $data->part->name : null)  !!}
                </td>
            </tr>

            <tr>
                <td>
                    <label>
                        <h6 class="mb5 mt10"> {{trans('taxonomy.cat_loai')}}</h6>
                    </label>
                </td>
                <td>
                    {!! (isset($data->type->name) && $data->type->name ? $data->type->name : null)  !!}
                </td>
            </tr>

            <tr>
                <td>
                    <label>
                        <h6 class="mb5 mt10"> {{trans('taxonomy.cat_name')}}</h6>
                    </label>
                </td>
                <td>
                    {!! (isset($data->category->name) && $data->category->name ? $data->category->name : null)  !!}
                </td>
            </tr>

            <tr>
                <td>
                    <label>
                        <h6 class="mb5 mt10"> {{trans('order.config')}}</h6>
                    </label>
                </td>
                <td>
                    {!! (isset($data->config) && $data->config ? $data->config : null)  !!}
                </td>
            </tr>

            <tr>
                <td>
                    <label>
                        <h6 class="mb5 mt10"> {{trans('order.amount')}}</h6>
                    </label>
                </td>
                <td>
                    {!! (isset($data->amount) && $data->amount ? $data->amount : null)  !!}
                </td>
            </tr>

            <tr>
                <td>
                    <label>
                        <h6 class="mb5 mt10"> {{trans('order.purchase_date')}}</h6>
                    </label>
                </td>
                <td>
                    {!! (isset($data->purchase_date) && $data->purchase_date ? $data->purchase_date : null)  !!}
                </td>
            </tr>

            <tr>
                <td>
                    <label>
                        <h6 class="mb5 mt10"> {{trans('order.price')}}</h6>
                    </label>
                </td>
                <td>
                    {!! (isset($data->price) && $data->price ? $data->price : null)  !!}
                </td>
            </tr>

            <tr>
                <td>
                    <label>
                        <h6 class="mb5 mt10"> {{trans('order.guarantee')}}</h6>
                    </label>
                </td>
                <td>
                    {!! (isset($data->guarantee) && $data->guarantee ? $data->guarantee : null)  !!}
                </td>
            </tr>

            <tr>
                <td>
                    <label>
                        <h6 class="mb5 mt10"> {{trans('order.phone_number')}}</h6>
                    </label>
                </td>
                <td>
                    {!! (isset($data->phone_number) && $data->phone_number ? $data->phone_number : null)  !!}
                </td>
            </tr>

            <tr>
                <td>
                    <label>
                        <h6 class="mb5 mt10"> {{trans('order.address')}}</h6>
                    </label>
                </td>
                <td>
                    {!! (isset($data->address) && $data->address ? $data->address : null)  !!}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>