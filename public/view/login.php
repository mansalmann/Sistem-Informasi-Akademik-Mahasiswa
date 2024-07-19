<div class="container px-4 py-5">

    <div class="row align-items-center g-lg-5 py-5">
        <div class="col-md-7 mx-auto col-lg-4">
        <h1 class="display-4 fw-bold lh-1 mb-3">Login</h1>        
            <form class="p-4 p-md-5 border rounded-3 bg-light" method="post" action="/login">
                <!-- cek ada error atau tidak -->
                    <?php if(isset($responseData["error"])){ ?>
                        <div class="row w-100 mx-auto">
                            <div class="alert p-2 text-center alert-danger" role="alert">
                            <?= $responseData["error"] ?>
                            </div>
                        </div>
                    <?php }?>
                <div class="mb-3 input-nim">
                    <label for="nim" class="form-label">Nomor Induk Mahasiswa</label>
                    <input type="text" name="nim" class="form-control w-100" id="nim">
                </div>
                <div class="mb-3 input-password">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control w-100" id="password">
                </div>
                <button type="submit" name="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>
    </div>
</div>