<div class="chat-header clearfix">
  @include('chat._header')
</div>
<div class="chat-history">
  @include('chat._chat')
</div>

<div class="chat-message clearfix">
  <!-- <div class="input-group mb-0">
    <div class="input-group-prepend">
      <span class="input-group-text"><i class="fa fa-send"></i></span>
    </div>
    <input type="text" class="form-control" placeholder="Enter text here...">
  </div> -->
    <form action="" id="submit_message" method="post" class="mb-0" enctype="multipart/form-data">
      <input type="hidden" value="{{ $getReceiver->id }}" name="receiver_id">
      {{ csrf_field() }}
      <textarea class="form-control emojionearea" name="message" id="ClearMessage" required></textarea>
      <div class="row">
        <div class="col-md-6 hidden-sm" style="margin-top: 10px;">
          <a href="javascript::void(0);" class="btn btn-outline-primary" id="OpenFile"><i class="fa fa-image"></i></a>
          <input type="file" name="file_name" id="file_name" style="display: none;">

          <a href="javascript::void(0);" class="btn btn-outline-secondary" id="OpenCamera"><i class="fa fa-camera"></i></a>

        </div>
        <div class="col-md-6" style="text-align: right;">
          <button class="btn btn-primary" style="margin-top: 10px;" type="submit">Send</button>
        </div>
        <span id="getFileName"></span>
      </div>
  </form>
  <video id="myvideo" width="400px" height="200px" autoplay></video>
</div>

