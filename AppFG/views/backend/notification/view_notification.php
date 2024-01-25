<!doctype html>
<html lang="en">
<head>
</head>
<body>
    <main role="main">
        <!-- Modal -->
        <div class="modal show" id="notification_modal" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" id="cancel" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Notification</h4>
                    </div>
                    <div class="modal-body">
                        <?php foreach ($all_notification as $row) : ?>
                            <?php
                            if (
                                in_array($this->session->userdata('id'), json_decode($row['to_user_id']))
                                ||
                                in_array($this->session->userdata('role'), json_decode($row['to_group_name']))
                            ) :
                            ?>
                            <details>
                                <summary><?php echo $row['title']; ?></summary>
                            </details>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
    (function() {
      var modal = document.getElementById('notification_modal');
      var cancelButton = document.getElementById('cancel');

      cancelButton.addEventListener('click', function() {
        modal.remove("show");
      });

    })();
  </script>
</body>
</html>