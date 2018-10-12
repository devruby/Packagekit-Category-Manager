<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">{!! trans('order.show_detail_order') !!}</h4>
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
                        <h6 class="mb5 mt10"> {{trans('order.user_name')}}</h6>
                    </label>
                </td>
                <td>
                    {!! (isset($data->user->name) && $data->user->name ? $data->user->name : null)  !!}
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                        <h6 class="mb5 mt10"> {{trans('order.team')}}</h6>
                    </label>
                </td>
                <td>
                    {!! (isset($data->user->team->name) && $data->user->team->name ? $data->user->team->name : null)  !!}
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                        <h6 class="mb5 mt10"> {{trans('order.user_role')}}</h6>
                    </label>
                </td>
                <td>
                    {!! (isset($data->user->role->display_name) && $data->user->role->display_name ? $data->user->role->display_name : null)  !!}
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                        <h6 class="mb5 mt10"> {{trans('taxonomy.cat_part')}}</h6>
                    </label>
                </td>
                <td>
                    {!! (isset($data->orders->part->name) && $data->orders->part->name ? $data->orders->part->name : null)  !!}
                </td>
            </tr>

            <tr>
                <td>
                    <label>
                        <h6 class="mb5 mt10"> {{trans('taxonomy.cat_type')}}</h6>
                    </label>
                </td>
                <td>
                    {!! (isset($data->orders->type->name) && $data->orders->type->name ? $data->orders->type->name : null)  !!}
                </td>
            </tr>

            <tr>
                <td>
                    <label>
                        <h6 class="mb5 mt10"> {{trans('order.config')}}</h6>
                    </label>
                </td>
                <td>
                    {!! (isset($data->orders->config) && $data->orders->config ? $data->orders->config : null)  !!}
                </td>
            </tr>

            <tr>
                <td>
                    <label>
                        <h6 class="mb5 mt10"> {{trans('order.purchase_date')}}</h6>
                    </label>
                </td>
                <td>
                    {!! (isset($data->orders->purchase_date) && $data->orders->purchase_date ? $data->orders->purchase_date : null)  !!}
                </td>
            </tr>

            <tr>
                <td>
                    <label>
                        <h6 class="mb5 mt10"> {{trans('order.guarantee')}}</h6>
                    </label>
                </td>
                <td>
                    {!! (isset($data->orders->guarantee) && $data->orders->guarantee ? $data->orders->guarantee : null)  !!}
                </td>
            </tr>

            <tr>
                <td>
                    <label>
                        <h6 class="mb5 mt10"> {{trans('order.note')}}</h6>
                    </label>
                </td>
                <td>
                    {!! (isset($data->note) && $data->note ? $data->note : null)  !!}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>