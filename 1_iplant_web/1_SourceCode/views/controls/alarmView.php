<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.css" integrity="sha256-jLWPhwkAHq1rpueZOKALBno3eKP3m4IMB131kGhAlRQ=" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.js" integrity="sha256-bFpArdcNM5XcSM+mBAUSDAt4YmEIeSAdUASB2rrSli4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.js" integrity="sha256-Mu1bnaszjpLPWI+/bY7jB6JMtHj5nn9zIAsXMuaNxdk=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
<style>
    #calendar-container {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    }
</style>
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fa-solid fa-calendar-day"></i></div>
                        LỊCH TƯỚI NƯỚC
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <button class="btn btn-sm btn-light text-primary" type="button" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fa-solid fa-calendar-plus me-1"></i>
                        THÊM LỊCH TƯỚI
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container px-4">
    <div class="card">
        <div class="card-body">
            <div id='calendar'></div>
        </div>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Thêm lịch tưới</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addForm" method="post" action="Javascript:void(0);">
                    <div class="mb-3">
                        <label class="small mb-1">Chậu cây</label>
                        <select class="form-select" aria-label="Lựa chọn quyền hạn" name="imei" required>
                            <option selected disabled>Lựa chọn chậu cây</option>
                            <?php foreach ($imeis as $imei){?>
                            <option value="<?php echo $imei[0]?>"><?php echo $this->Model->fetchOne("select name from plants where imei='".$imei[0]."'")[0]." (".$imei[0].")"; ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1">Chọn thời gian tưới</label>
                        <input type="datetime-local" class="form-control" name="set_time" id="start_datetime" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="loop_id" checked name='flag_loop'>
                            <label class="form-check-label" for="loop_id">Lặp lại hằng ngày.</label>
                        </div>
                    </div>
                    <div class="form-check form-check-solid">
                        <input class="form-check-input" id="flag_pumpCheck" type="checkbox" name="flag_pump" checked>
                        <label class="form-check-label" for="flag_pumpCheck">Tưới cây</label>
                    </div>
                    <div class="form-check form-check-solid">
                        <input class="form-check-input" id="flag_uvCheck" type="checkbox" name="flag_uv">
                        <label class="form-check-label" for="flag_uvCheck">Bật đèn quang hợp</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Đóng</button><button class="btn btn-primary" id="btnAdd" type="button">Thêm</button></div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Chỉnh sửa lịch tưới</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="post" action="Javascript:void(0);">
                    <div class="mb-3">
                        <label class="small mb-1">Chậu cây</label>
                        <input class="form-control form-control-solid" type="text" aria-label="Nhập IMEI chậu của bạn" aria-describedby="plantImeiExample" name="imei_edit" />
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1">Chọn thời gian tưới</label>
                        <input type="datetime-local" class="form-control form-control-sm" name="set_time_edit" id="set_time" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="loop_id" checked name='flag_loop_edit'>
                            <label class="form-check-label" for="loop_id">Lặp lại hằng ngày.</label>
                        </div>
                    </div>
                    <div class="form-check form-check-solid">
                        <input class="form-check-input" type="checkbox" name="flag_pump_edit" checked>
                        <label class="form-check-label" for="flag_pumpCheck">Tưới cây</label>
                    </div>
                    <div class="form-check form-check-solid">
                        <input class="form-check-input" type="checkbox" name="flag_uv_edit">
                        <label class="form-check-label" for="flag_uvCheck">Bật đèn quang hợp</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="reset" data-bs-dismiss="modal">Đóng</button><button form="editForm" class="btn btn-primary" id="btnEdit" type="button">Sửa</button></div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xem chi tiết</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <dl>
                        <dt class="text-muted">Tiêu đề</dt>
                        <dd id="title" class="fw-bold fs-4"></dd>
                        <dt class="text-muted">Trạng thái</dt>
                        <dd id="status" class="fw-bold fs-4"></dd>
                        <dt class="text-muted">Thời gian tưới</dt>
                        <dd id="start" class=""></dd>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="loopChecked" checked>
                                <label class="form-check-label" for="loopChecked">Lặp lại hằng ngày.</label>
                            </div>
                        </div>
                        <div class="form-check form-check-solid">
                            <input class="form-check-input" id="pumpChecked" type="checkbox" data-pump="" disabled>
                            <label class="form-check-label" for="pumpChecked">Tưới cây</label>
                        </div>
                        <div class="form-check form-check-solid">
                            <input class="form-check-input" id="uvChecked" type="checkbox" data-uv="" disabled>
                            <label class="form-check-label" for="uvChecked">Bật đèn quang hợp</label>
                            </div>
                    </dl>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Đóng</button>
                <button class="btn btn-primary" type="button" id="edit" id-data="">Sửa</button>
                <button class="btn btn-danger" id="delete" id-data="" type="button">Xoá</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL -->
<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
    console.log(scheds);
    document.addEventListener('DOMContentLoaded',function(){
        var initialLocaleCode = 'vi';
        var calendar;
        var Calendar = FullCalendar.Calendar;
        var events = [];
        if (!!scheds) {
            Object.keys(scheds).map(k => {
                var row = scheds[k]
                events.push({ id: row.id, title: row.title, start: row.time_set, pumpChecked: row.pumpChecked, uvChecked: row.uvChecked, loopChecked: row.loopChecked});
                console.log(events);
            })
        }
        var date = new Date()
        calendar = new Calendar(document.getElementById('calendar'), {
            headerToolbar: {
                left: 'prev,next,today,timeGridWeek,listMonth',
                right: ''
            },
            selectable: true,
            events: events,
            locale: initialLocaleCode,
            eventClick: function(info) {
                var _details = $('#event-details-modal')
                var id = info.event.id
                console.log(id);
                if (!!scheds[id]) {
                    _details.find('#title').text(scheds[id].title)
                    _details.find('#status').text(scheds[id].status)
                    _details.find('#start').text(scheds[id].sdate)
                    var isLoopChecked = scheds[id].loopChecked;
                    var isPumpChecked = scheds[id].pumpChecked;
                    var isUVChecked = scheds[id].uvChecked;
                    if(isLoopChecked == "checked"){
                        _details.find('#loopChecked').prop("checked", true);
                        _details.find('#loopChecked').attr('data-loop', "checked")                        
                    }else{
                        _details.find('#loopChecked').prop("checked", false);
                        _details.find('#loopChecked').attr('data-loop', "unchecked")
                    }
                    if(isPumpChecked == "checked"){
                        _details.find('#pumpChecked').prop("checked", true);
                        _details.find('#pumpChecked').attr('data-pump', "checked")                        
                    }else{
                        _details.find('#pumpChecked').prop("checked", false);
                        _details.find('#pumpChecked').attr('data-pump', "unchecked")
                    }
                    if(isUVChecked == "checked"){
                        _details.find('#uvChecked').prop("checked", true);
                        _details.find('#uvChecked').attr('data-uv', "checked")                        
                    }else{
                        _details.find('#uvChecked').prop("checked", false);
                        _details.find('#uvChecked').attr('data-uv', "unchecked")     
                    }
                    _details.find('#edit,#delete').attr('data-id', id)
                    _details.find('#edit,#delete').attr('data-imei', scheds[id].imei)
                    _details.modal('show')
                } else {
                    alert("Không tìm thấy sự kiện.");
                }
            },
        });
        calendar.render();

        $('#btnAdd').click(function() {
            $.post('../../api/controls/alarm.php?act=add', $('#addForm').serialize(), function(data){
                console.log(data);
                if(data.noti == "Thêm lịch thành công"){
                    alert("Thêm lịch thành công!");
                    location.reload();
                }
            });
        });
        var idCurr;
        $('#edit').click(function() {
            var id = $(this).attr('data-id')
            idCurr =  id
            var imei = $(this).attr('data-imei')
            
            $('#event-details-modal').modal('hide')
            if (!!scheds[id]){
                var _form = $('#editModal')
                _form.find('[name="imei_edit"]').val(imei)
                var isLoopCheck = scheds[idCurr].loopChecked;
                var isPumpCheck = scheds[idCurr].pumpChecked;
                var isUVCheck = scheds[idCurr].uvChecked;
                if(isLoopCheck == "checked"){
                    _form.find('[name="flag_loop_edit"]').prop("checked", true);                     
                }else{
                    _form.find('[name="flag_loop_edit"]').prop("checked", false);
                }
                if(isPumpCheck == "checked"){
                    _form.find('[name="flag_pump_edit"]').prop("checked", true);                  
                }else{
                    _form.find('[name="flag_pump_edit"]').prop("checked", false);
                }
                if(isUVCheck == "checked"){
                    _form.find('[name="flag_uv_edit"]').prop("checked", true);                        
                }else{
                    _form.find('[name="flag_uv_edit"]').prop("checked", false);    
                }
                
                _form.find('[name="set_time_edit"]').val(String(scheds[id].time_set).replace(" ", "T"))
            }
            $('#editModal').modal('show')
        });

        $('#btnEdit').click(function() {
            $.post('../../api/controls/alarm.php?act=edit&id='+idCurr, $('#editForm').serialize(), function(data){
                console.log(data);
                if(data.noti == "Sửa lịch thành công"){
                    alert("Sửa lịch thành công!");
                    location.reload();
                }
            });
        });

        $('#delete').click(function() {
            var _conf = confirm("Bạn có thực sự muốn xoá không?");
            var id = $(this).attr('data-id')
            if (_conf === true) {
                $.post('../../api/controls/alarm.php?act=delete&id='+id, function(data){
                    console.log(data);
                    if(data.noti == "Xoá lịch thành công"){
                        alert("Xoá lịch thành công!");
                        location.reload();
                    }
                });
            }
        });
    });
</script>