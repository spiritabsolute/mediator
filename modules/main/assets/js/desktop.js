$(document).ready(function(){

var conn = new ab.Session('ws://127.0.0.1:8080',
    function() {
        conn.subscribe('eventMonitoring', function(topic, data) {

            var desctopContainer = $('#listEvents'), eventBlock = '';

            var date = new Date(data.created_at*1000);
            var dateEvent = date.toLocaleString();

            if(desctopContainer)
            {
                var blockSelector = '#'+data.created_at;

                eventBlock = '<div id="'+data.created_at+'" class="item">';
                eventBlock += $('#storage-template-event-block').html();
                eventBlock += '</div>';
                desctopContainer.prepend(eventBlock);

                $(blockSelector).find('#panel-heading').text(dateEvent);
                $(blockSelector).find('#panel-body-entity')
                    .text($('#lable-entity').text()+data.entity);
                $(blockSelector).find('#panel-body-type')
                    .text($('#lable-type').text()+data.type);
                $(blockSelector).find('#panel-body-author')
                    .text($('#lable-author').text()+data.author);

                if(data.changes)
                {
                    var listChanges = '<p>'+$('#lable-changes').text()+'</p>';
                    listChanges += '<ul class="list-group">';
                    for(var k in data.changes)
                    {
                        listChanges += '<li class="list-group-item">';
                        listChanges += k+' = '+data.changes[k];
                        listChanges += '</li>';
                    }
                    listChanges += '</ul>';
                    $('#panel-body').append(listChanges);
                }
            }
        });
    },
    function() {
        console.warn('WebSocket connection closed');
    },
    {'skipSubprotocolCheck': true}
);

});