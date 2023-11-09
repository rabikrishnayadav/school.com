<div class="row">
  <div class="col-lg-12">
    <a href="javascript::void(0);" data-toggle="modal" data-target="#view_info">
      <img src="{{ $getReceiver->getProfileDirect() }}" alt="avatar">
    </a>
    <div class="chat-about">
      <h6 class="m-b-0">{{ $getReceiver->name }} {{ $getReceiver->last_name }}</h6>
      <small style="margin-bottom: 0px;">
        @if(!empty($getReceiver->OnlineUser()))
        <span style="color: green;">Online</span>
        @else
        Last seen: {{ Carbon\Carbon::parse($getReceiver->updated_at)->diffForHumans() }}
        @endif
      </small>
    </div>
  </div>
  
</div>