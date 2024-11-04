  <div class="modal fade" id="gantiPasswordModal{{ Session::get('user.id') }}" tabindex="-1"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header bg-light p-3">
                  <h5 class="modal-title" id="exampleModalLabel">Ganti Password</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                      id="close-modal"></button>
              </div>
              <form method="POST" action="{{ url('pengaturan/user/cp/' . Session::get('user.id')) }}">
                  @method('PUT')
                  @csrf
                  <div class="modal-body">
                    <input type="hidden" name="username" value="{{ Session::get('user.username') }}">
                      <div class="mb-3" id="modal-id">
                          <label class="form-label">Password Lama</label>
                          <input type="password" name="pw" id="id-field" class="form-control"
                              placeholder="Password Lama" required />
                      </div>
                      <div class="mb-3" id="modal-id">
                          <label class="form-label">Password Baru</label>
                          <input type="password" id="id-field" name="pw2" class="form-control"
                              placeholder="Password Lama" required />
                      </div>
                  </div>
                  <div class="modal-footer">
                      <div class="hstack gap-2 justify-content-end">
                          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success" id="add-btn">Ganti Password</button>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
  <div class="modal fade zoomIn" id="logoutModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                      id="btn-close"></button>
              </div>
              <div class="modal-body">
                  <form id="logout-form" action="{{ url('/logout') }}" method="POST">
                      @csrf
                      <div class="mt-2 text-center">
                          <img src="{{ URL::asset('assets/images/goodbye2.gif') }}" style="width:auto;height:100%">
                          <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                              <h4>Ingin Logout ?</h4>
                          </div>
                      </div>
                      <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                          <a type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Tidak</a>
                          <button type="submit" class="btn w-sm btn-danger ">Ya !</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
  <footer class="footer">
      <div class="container-fluid">
          <div class="row">
              <div class="col-sm-6">
                  <a>{{ date('Y') }}</a> © Evo Nusa.
              </div>
              <div class="col-sm-6">
                  <div class="text-sm-end d-none d-sm-block">
                      Design & Develop by Themesbrand
                  </div>
              </div>
          </div>
      </div>
  </footer>
