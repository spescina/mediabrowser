$(function() {

        ZZ.ajax = function(settings)
        {        
                var options = {
                        cache: false,
                        type: "GET",
                        dataType: "json"
                };
                
                $.extend(options, settings);
                
                var dfd;
             
                var request = function(options)
                {
                        dfd = new jQuery.Deferred();
                        
                        return $.ajax(options);
                };
                
                var run = function(url, params, success, fail)
                {
                        if (typeof url === 'undefined')
                        {
                                callbackFail();
                        }
                        
                        var args = options;
                        
                        if (typeof params !== 'undefined')
                        {
                                args.data = params;
                        }
                        
                        args.error = (typeof fail !== 'undefined') ? fail : callbackFail;
                        
                        args.url = url;
                        
                        request(args).done(function(data){
                                if (typeof success !== 'undefined') {
                                        success(data);
                                }
                                
                                dfd.resolve(data);
                        });
                        
                        return dfd.promise();
                };
                
                var callbackFail = function()
                {
                        dfd.reject();
                        
                        alert('AJAX Error');
                };
                
                return {
                        run: run
                };
        };
        
});