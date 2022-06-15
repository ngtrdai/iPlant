<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user"></i></div>
                        Danh sách người dùng
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="?controller=users/add">
                        <i class="me-1" data-feather="user-plus"></i>
                        Thêm người dùng
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container-fluid px-4">
    <div class="card">
        <div class="card-body">
            <table id="dbUserList">
                <thead>
                    <tr>
                        <th>Họ và tên</th>
                        <th>Tên người dùng</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>iPlant</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Họ và tên</th>
                        <th>Tên người dùng</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>iPlant</th>
                        <th>Hành động</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach($users as $user) {?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar me-2"><img class="avatar-img img-fluid" src="<?php echo $user['avatar_img'] ?>" /></div>
                                <?php echo $user['fullname'] ?>
                            </div>
                        </td>
                        <td><?php echo $user['username'] ?></td>
                        <td><?php echo $user['email'] ?></td>
                        <td><?php echo $user['role'] ?></td>
                        <td>
                            <?php 
                                $plants = $this->Model->fetch("select imei from owned where username='".$user['username']."'");
                                foreach ($plants as $plant){
                                    echo "<span class='badge bg-green-soft text-green me-1'>".$plant[0]."</span>";
                                }
                                
                            ?>
                        </td>
                        <td>
                            <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="?controller=users/edit&token=<?php echo $user['token'] ?>"><i data-feather="edit"></i></a>
                            <a class="btn btn-datatable btn-icon btn-transparent-dark" href="?controller=users/list&act=delete&token=<?php echo $user['token'] ?>"><i data-feather="trash-2"></i></a>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
window.addEventListener('DOMContentLoaded', event => {
    const dbUserList = document.getElementById('dbUserList');
    if (dbUserList) {
        new simpleDatatables.DataTable(dbUserList);
    }
});
</script>