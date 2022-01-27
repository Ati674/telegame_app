import UIkit from 'uikit';

export const TelegameCommon = {
    Ajax: function (httpMethod, url, data, type, successCallback, beforeSend, completeAjaxRequest, async, cache) {
        if (typeof async == "undefined") {
            async = true;
        }
        if (typeof cache == "undefined") {
            cache = false;
        }

        return $.ajax( {
            type: httpMethod.toUpperCase(),
            url: url,
            data: data,
            dataType: type,
            async: async,
            cache: cache,
            beforeSend: beforeSend,
            success: successCallback,
            complete: completeAjaxRequest,
            error: function (err, type, httpStatus) {
                TelegameCommon.AjaxFailureCallBack( err, type, httpStatus )
            }
        } );
    },

    DisplaySuccess: function (message) {
        TelegameCommon.ShowSuccessSavedMessage(message)
    },

    DisplayError: function (error) {
        TelegameCommon.ShowFailSavedMessage(error)
    },

    AjaxFailureCallBack: function (err, type, httpStatus) {
        let failureMessage = 'Erreur lors de l\'appel ajax (status : ' + err.status + " - " + err.responseText + " - " + httpStatus;
        console.log(failureMessage)
        UIkit.alert({
            message: failureMessage
        },{
            type: 'danger'
        });
    },

    ShowSuccessSavedMessage: function (messageText) {
        UIkit.alert({
            message: failureMessage
        },{
            type: 'danger'
        });
    },

    ShowFailSavedMessage: function (messageText) {
        UIkit.alert({
            message: failureMessage
        },{
            type: 'danger'
        });
    }
}
