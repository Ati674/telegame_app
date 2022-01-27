import bootstrap from 'bootstrap';
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
