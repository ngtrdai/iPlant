<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-xl px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="settings"></i></div>
                        Cài đặt
                    </h1>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container-xl px-4 mt-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">Cập nhật README</div>
                <div class="card-body">
                    <form id="content_form" method="post">
                        <div class="mb-3">
                            <textarea id="postEditor" name="content"></textarea>
                        </div>
                        <button class="btn btn-primary" type="submit">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">Sao lưu cơ sở dữ liệu </div>
                <div class="card-body">
                    <p>Chức năng chưa xài được, từ từ sẽ có.😊</p>
                    <div class="row">
                        <div class="col-lg-6 mb-2">
                            <button class="btn btn-info" style="width: 100%"><strong>SAO LƯU 📅</strong></button>
                        </div>
                        <div class="col-lg-6">
                            <button class="btn btn-primary" style="width: 100%"><strong>TẢI XUỐNG ⬇️</strong></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Thêm chậu cây</div>
                <div class="card-body">
                    <p>Thêm chậu cây chỉ với 1 nhút nhấn.😊</p>
                    <div class="row">
                        <div class="col-lg-6 mb-2">
                            <button class="btn btn-info" id="btnAdd1Chau" style="width: 100%"><strong>THÊM 1 CHẬU</strong></button>
                        </div>
                        <div class="col-lg-6">
                            <button class="btn btn-primary" id="btnAdd5Chau" style="width: 100%"><strong>THÊM 5 NHIỀU CHẬU</strong></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://unpkg.com/easymde/dist/easymde.min.js" crossorigin="anonymous"></script>
<script>
    var easyMDE = new EasyMDE({
            element: document.getElementById('postEditor'),
            toolbar: ['bold', 'italic', 'heading', '|', 'quote', 'unordered-list', 'ordered-list', '|', 'link', 'image', '|', 'preview', 'guide']
    });
    getInfo();
    $(document).ready(function(){
        $(document).on('submit', '#content_form', function(){
            updateInfo();
            return false;
        });
        $("#btnAdd1Chau").click(function(){
            $.post('../api/settings/addPlants.php?act=add1Chau',function(data){
                if(data == "Thêm chậu thành công."){
                    alert(data);
                }
            });
            return false;
        });
        $("#btnAdd5Chau").click(function(){
            $.post('../api/settings/addPlants.php?act=addNChau',function(data){
                if(data == "Thêm chậu thành công."){
                    alert(data);
                }
            });
            return false;
        });
    });
    
    function getInfo(){
        $.post('../api/settings/readme.php?act=getValue',function(data){
            easyMDE.value(data[0]);
        });
    };

    function updateInfo(){
        $.post('../api/settings/readme.php?act=update',$('#content_form').serialize(),function(data){
            alert("Thành công");
        })
    };
</script>