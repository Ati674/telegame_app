import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';

// loads the Icon plugin
UIkit.use(Icons);
import '../scss/app.scss';

// components can be called from the imported UIkit reference
// or get all of the named exports for further usage
import $ from 'jquery';
window.jQuery = $;
window.$ = $;

require('jquery-validation')
require("bootstrap-notify");
//== Set defaults

$.notifyDefaults({
    template: '' +
        '<div data-notify="container" class="alert alert-{0} m-alert" role="alert">' +
        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss"></button>' +
        '<span data-notify="icon"></span>' +
        '<span data-notify="title">{1}</span>' +
        '<span data-notify="message">{2}</span>' +
        '<div class="progress" data-notify="progressbar">' +
        '<div class="progress-bar progress-bar-animated bg-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
        '</div>' +
        '<a href="{3}" target="{4}" data-notify="url"></a>' +
        '</div>'
});

export function successCallback(){
    $.notify({
        message: 'Transaction effectué avec succès, votre participation à bien été prise en compte !',
        type: 'success'
    })
}
