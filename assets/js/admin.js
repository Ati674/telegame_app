// any CSS you import will output into a single css file (app.css in this case)
import '../scss/admin.scss';
import {TelegameCommon} from "./AjaxRequest";
import UIkit from "uikit";

$(document).ready( function () {
   $('.validate_payment').click(function (e) {
      let $this = $(this);
      e.preventDefault();
      TelegameCommon.Ajax('POST', $(this).data('url'), '','json', successCallback)
      function successCallback(response) {
         $this.parent().parent().remove();
          UIkit.notification({
              message: 'Participant validé',
              status: 'success',
              pos: 'top-right',
              timeout: 5000
          });
      }
   });
});
