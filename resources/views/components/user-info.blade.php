<div>
  <!-- Modal -->
  <div class="modal fade" id="userInfoModal" tabindex="-1" aria-labelledby="userInfoModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-dark">
        <div class="modal-header">
          <h5 class="modal-title" id="userInfoModal">User Infomation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="\editUserInfo" method="post">
            @csrf
            <p class="form-text text-white-50 text-left">データを引き継ぐ場合はIDを入力してください</p>
            <div class="row">
              <div class="col">
                <label for="postID" class="pull-left">ID </label>
                <input type="text" class="form-control" name="postID" placeholder="Enter ID"
                  value="{{ $user->instant_id }}">
              </div>
              <div class="col">
                <label for="postName" class="pull-left">名前 </label>
                <input type="text" class="form-control" name="postName" placeholder="name"
                  value="{{ $user->name }}">
              </div>
            </div>
            <small id="ID help" class="form-text text-muted mt-auto pull-left">※IDを他人に教えないでください</small>
            <br>
            <hr>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
