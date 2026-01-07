<div class="custom-control custom-control-success custom-switch" id="cousome_switch"
      data-id= {{ $data->id }}
     >
    <input type="checkbox" {{ $data->status == 'active' ? "checked" : "" }}  class="custom-control-input" id="customSwitch4{{  $data->id }}" />
    <label class="custom-control-label" for="customSwitch4{{  $data->id }}"></label>
 </div>
