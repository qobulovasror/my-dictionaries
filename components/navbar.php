<div class="navbar bg-body-tertiary w-100">
    <div class="container">
        <div class="row d-flex justify-content-between w-100 pt-3">
            <div class="col" style="height: 50px">
                <a href="/" class="navbar-brand">
                    <h2>My vocabulary</h2>
                </a>
            </div>
            <div class="col" style="height: 50px">
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Izlash..." />
                    <button class="btn btn-outline-success" type="submit">
                        Izlash
                    </button>
                </form>
            </div>
            <div class="col d-flex justify-content-end" style="height: 50px">
            <?php if (empty($_SESSION["auth"])){ ?>
                <a href="../templates/login.php" type="button" class="btn btn-primary" style="height: 40px">  
                    Kirish
                </a>
                <?php } else{ ?>
                    <div class="d-flex">
                        <a href="/templates/createTable.php" class="btn btn-primary me-2"  style="height: 40px">Yangi lug'at turini yaratish</a>
                        <a href="/?logout=1" class="btn btn-danger"  style="height: 40px">Chiqish</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <hr class="bg-secondary-subtle m-0" />
</div>