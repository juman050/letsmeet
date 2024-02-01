
require('./bootstrap');

window.Vue = require('vue');
var moment = require('moment');

const app = new Vue({
    el: '#app',
    data: {
    	msg: 'Click on user to start messaging.',
    	conversations: [],
    	conversationMessages: [],
    	msgFrom: '',
    	newMsgFrom: '',
    	follow_id: '',
   		conID: '',
   		seen: false
    },
	mounted: function(){
		this.getAllConversations();
	},
	methods: {	
		// formatDate: function(date) {
  //           // return moment(date).fromNow();
  //           return date;
  //       },
		getAllConversations: function () {
			axios.get('/letsmeetupdate/get-all-conversations')
			.then(function (response) {
				app.conversations = response.data;
			})
			.catch(function (error) {
            	console.log(error); // run if we have error
            });
		},
		getmessages(id){
	        axios.get('/letsmeetupdate/get-conversation-message/'+id)
			.then(function (response) {
				app.conversationMessages = response.data;
				app.conID = response.data[0].conversation_id
				console.log(response.data)
			})
			.catch(function (error) {
               console.log(error); // run if we have error
            });
	    },
	    inputHandler(e){
		    if(e.keyCode ===13 && !e.shiftKey){
		       e.preventDefault();
		       this.sendMsg();
		    }
	    },
	    sendMsg: function () {
	     if(this.msgFrom){
	       axios.post('/letsmeetupdate/sendMessage', {
	              conID: this.conID,
	              msg: this.msgFrom
	            })
	            .then(function (response) {             
	              console.log(response.data); // show if success
	              if(response.status===200){
	                app.conversationMessages = response.data;
	                app.msgFrom= "";
	              }

	            })
	            .catch(function (error) {
	              console.log(error); // run if we have error
	            });

	     }
	   },
	   followID: function(id){
    	app.follow_id = id;
    	app.msg="";
	    },
	    sendNewMsg(){
	     	axios.post('/letsmeetupdate/sendNewMessage', {
	            follow_id: this.follow_id,
	            msg: this.newMsgFrom,
	        })
	        .then(function (response) {
	            console.log(response.data); // show if success
	            if(response.status===200){
	              window.location.replace('/letsmeetupdate/conversations');
	              app.msg = 'your message has been sent successfully';
	            }

	        })
	        .catch(function (error) {
	            console.log(error); // run if we have error
	        });
	   }
	}

});
