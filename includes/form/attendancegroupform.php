<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click', ".showattendancegroup", function(){
      var companyID = $(this).data('id');
      var alldata = "companyID="+companyID;
      $.ajax({
        url: "ajax-getattendancegroup.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        dataType:"json",
        success:function(data){
          $("#showattendancegroupID").html(data.html);
          $("#showattendancegroupName").val(data.name);
        }
      });
    });
  });
</script>
<!-- Modal for show attendance group details -->
<div class="modal fade" id="adminshowattendancegroup">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h6 class="modal-title text-white" id="scoreboardModalLabel"><?php echo $array['company']?> <?php echo $array['membership']?></h6>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

        <div class="form-group">
          <div class="row">
            <div class="col-2"><label><?php echo $array['company']?> :</label></div>
            <div class="col">
              <input type="text" class="form-control-plaintext form-control-sm" id="showattendancegroupName" name="showattendancegroupName" readonly>
            </div>
          </div>
        </div>
        <div class="my-3" id="showattendancegroupID"></div>
        <button type="button" class="btn btn-danger float-right" data-dismiss="modal"><?php echo $array['no']?></button>
      </div>
    </div>
  </div>
</div>