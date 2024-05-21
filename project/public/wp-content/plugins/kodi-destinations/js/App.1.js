/// var used :  stampToday : today date generate in PHP class.client.php
var months = ['01','02','03','04','05','06','07','08','09','10','11','12'];

function verifMail(chaine) {
    var exp=new RegExp("^[a-zA-Z0-9\-\_\+.]{0,256}[@]{1}[a-zA-Z0-9\-\_\+.]{0,256}[.]{1}[a-zA-Z]{0,3}$","g");
    if ( exp.test(chaine) ){ return true; }
    else { return false; }
}



function timeConverter(UNIX_timestamp){
  var a = new Date( (UNIX_timestamp) * 1000 );
  var year = a.getFullYear();
  //var month = months[a.getMonth()];
  var month = months[a.getMonth()];
  var date = a.getDate();
  var hour = a.getHours();
  var min = (a.getMinutes()>9) ? a.getMinutes() : '0'+a.getMinutes() ;
  var sec = a.getSeconds();
  var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min ;
  return time;
}

function getDayFromStampRdv( UNIX_timestamp ) {

	var a = new Date( (UNIX_timestamp) * 1000 );
	var year = a.getFullYear();
	//var month = months[a.getMonth()];
	var month = months[a.getMonth()];
	var date = a.getDate();
	var time = year + '/' + month + '/' + date +' 00:00:00';
	//alert(time);
	return Math.round( new Date(time).getTime()/1000 ) ;
}



var btnSelectRdv = {
	//// composant bouton de sélection des heures
	selectHour: function(e){
		if(!jQuery(e.target).hasClass('disabled') ){
			if(!jQuery(e.target).hasClass('selected') ) {
				rdvString =  timeConverter( e.target.getAttribute("stamprdv") ); //  e.target.getAttribute("stamprdv");
				rdvStamp = e.target.getAttribute("stamprdv");
				wprdvModule.data.rdvString = rdvString;
				wprdvModule.data.rdvStamp = rdvStamp;
			}else{
				wprdvModule.data.rdvString = 0;
				wprdvModule.data.rdvStamp = 0;
			}
			document.tester.testSelectedRdv();			
		}
	},
	oninit: function(vnode) {
		this.data = wprdvModule.data;
		console.log(this.data.rdvString);
	},
	view: function(item) {
		var e = item.attrs;
		return m('div' , { 	onclick:this.selectHour,
							class:e.class,
							stampday :e.stampday, 
							stamphour:e.stamphour,
							stamprdv:e.stamprdv, 
						} , e.text )
	}
}

var colmunDay = {
	/////// composant colonne de sélection des heures
	view: function(vnode) {
		
		var stampDay =  wprdvModule.data.datesDisplayed[vnode.attrs.index]/1000; ///Math.round(wprdvModule.data.firstDateDisplayed/1000)+(vnode.attrs.index * 86400);

		//var moreClass = (s.index)

		return m('div',
			{ class:'selector-hours--hours' } ,
				m('div', {class:'selector-hours-headerDay'}, [timeConverter(stampDay) ]),
				rdvTimes.map(function(hour){
					var booked = (vnode.attrs.s.indexOf(parseInt(stampDay)+parseInt(hour.split('|')[2]))>-1  ||  wprdvModule.data.bookedDays.indexOf(stampDay) >= 0  )  ? "btn-select-hour  disabled" : "btn-select-hour ";
					
					var stampHour = hour.split('|')[2];
					var stampRdv = parseInt(stampDay)+parseInt(hour.split('|')[2]);
					//var newSelect = (wprdvModule.data.rdvStamp!=0;
					(wprdvModule.data.rdvStamp==stampRdv) ? booked+=" selected" : "" ; 

					return m(btnSelectRdv, {
						class: booked,
						stampday :  stampDay, 
						stamphour:stampHour,
						stamprdv: stampRdv,
						text: hour.split('|')[0]+' - '+hour.split('|')[1]
					})
				}) 
			)
	}
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
var form = {
	oninit: function(){
		
	},
	oncreate: function(){

	},
	onupdate: function() {

	},
	submit: function() {
		console.log('form submit');
		var errors =0;
		if( wprdvModule.data.name.length == 0 ) { jQuery('input[name=nom]').addClass('error'); errors ++; };
		if( wprdvModule.data.phone.length != 10 ) { jQuery('input[name=phone]').addClass('error'); errors ++; };
		if( !verifMail( wprdvModule.data.email) ) { jQuery('input[name=email]').addClass('error'); errors ++; };
		if( wprdvModule.data.message.length == 0 ) { jQuery('textarea[name=message]').addClass('error'); errors ++; };
		//return (errors>0) ? true : false;
		if(errors>0){
			return false;
		}else{
			m.request({
				method: "GET",
				url: window.location.href,
				data: { newRdv:wprdvModule.data }
			})
			.then(function(result) {
				//User.list = result.data
				console.log('------');
				console.log(result);
				(result == 1) ? wprdvModule.data.step = 3 : wprdvModule.data.step.step = 2 ;
				///wprdvModule.data.rdvListFromPersonSelected = result;
				///document.tester.testBookedRdv();
			})
		}
		return false;
		
	},
	setClass: function(e){
		e.target.classList.remove('error');
	},
	view: function() {
		return m('div', { class:'wprdv-form-container' }, [

			m('form', {action:'#' , enctype:'multipart/form-data' , id:'wprdvform' , class:'wprdv-form', action:'#' }, [
				m('input', {type:'text', class:'wprdv-input', name:'nom', onfocus:this.setClass, placeholder: 'votre nom', oninput: m.withAttr("value", wprdvModule.setName), value:wprdvModule.data.name   }),
				m('input', {type:'email', class:'wprdv-input',  name:'email', onfocus:this.setClass, placeholder: 'votre email', oninput: m.withAttr("value", wprdvModule.setEmail), value:wprdvModule.data.email }),
				m('input', {type:'tel', class:'wprdv-input', name:'phone', onfocus:this.setClass, placeholder: 'votre numéro de téléphone', oninput: m.withAttr("value", wprdvModule.setPhone), value:wprdvModule.data.phone }),
				m('textarea', { name:'message', class:'wprdv-input',  rows:'5', onfocus:this.setClass, placeholder: 'votre message', oninput: m.withAttr("value", wprdvModule.setMessage), value:wprdvModule.data.message }),
				m('button', { type:'button', id:'btn-send', class:'wprdv-input', onclick:this.submit } , ['ENVOYER'] )
			] )


		])
	}

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
var listeHoursDOM = {
	nextDays: function() {
		listeHoursDOM.defineNextDay( wprdvModule.data.datesDisplayed[2] );
	},
	previousDays: function() {
		if(new Date() < wprdvModule.data.datesDisplayed[0] ) listeHoursDOM.definePrevDay( wprdvModule.data.datesDisplayed[0] );
	},
	defineNextDay: function(stamp) {
		var d = new Date(stamp);
		wprdvModule.data.datesDisplayed[0] = new Date(stamp).setDate( d.getDate()+1 );
		wprdvModule.data.datesDisplayed[1] = new Date(stamp).setDate( d.getDate()+2 );
		wprdvModule.data.datesDisplayed[2] = new Date(stamp).setDate( d.getDate()+3 );
		console.log( wprdvModule.data.datesDisplayed );
	},
	definePrevDay: function(stamp) {
		var d = new Date(stamp);
		//d.setDate( d.getDate() );
		wprdvModule.data.datesDisplayed[0] = new Date(stamp).setDate( d.getDate()-3 );
		wprdvModule.data.datesDisplayed[1] = new Date(stamp).setDate( d.getDate()-2 );
		wprdvModule.data.datesDisplayed[2] = new Date(stamp).setDate( d.getDate()-1 );
		console.log( wprdvModule.data.datesDisplayed );
	},
	validChoice: function(){
		///alert('valid choice');
		wprdvModule.data.step = 2;
	},
	oncreate: function(){
		//
		//document.tester.testBookedRdv();
		///document.tester.testSelectedRdv();
	},
	onupdate: function(vnode) {
		//document.tester.testBookedRdv();
		//document.tester.testSelectedRdv();
	},
	oninit: function(vnode){
		//document.tester.testBookedRdv();
		//document.tester.testSelectedRdv();
	},
	view: function() {
		var s = JSON.stringify(wprdvModule.data.rdvListFromPersonSelected);
		//// composant generation des 3 colonnes de selection des heures
		return m('div', {id:'selector-hour', class:'selector-hours'},  [
			m('div', { class:'date-rdvSelected' },  [wprdvModule.data.rdvString] ),
			m('input', {type:'text', name:'rdvStamp' , value:wprdvModule.data.rdvStamp}),
			m('input', {type:'text',  name:'firstDateDisplayed' , value:Math.round(wprdvModule.data.firstDateDisplayed/1000)}),
			m('div', {id: 'selector-hour',  class:'selector-hours'}, [
				m('button' , {class: 'btn-previousDays', onclick:this.previousDays }, ['<']),
				m('div', {date:'1', class:'.selector-hours--day'} , [ m(colmunDay , {index:0, s:s}) ]),
				m('div', {date:'2', class:'.selector-hours--day'} , [ m(colmunDay , {index:1, s:s}) ]),
				m('div', {date:'3', class:'.selector-hours--day'} , [ m(colmunDay , {index:2, s:s}) ]),
				m('button' , {class: 'btn-nextDays', onclick:this.nextDays},  ['>']),
			] ),
			m('div', {}, [
				(wprdvModule.data.rdvStamp!=0) ?  m('buttom',{type:'button', id:'btn-validDate', class:'wprdv-button', onclick:this.validChoice  }, ['Valider la date']) : null,
			])

		] );
	}
}

document.tester = {
	
	testBookedRdv: function () {
		/*jQuery(".btn-select-hour").removeClass('disabled');
		var e=wprdvModule.data.rdvListFromPersonSelected;
		console.log( wprdvModule.data.rdvListFromPersonSelected );
		for( var i=0 ; i<e.length ; i++ ){
				if( document.querySelector('div[stamprdv="'+e[i].date_time_rdv+'"]') ){
					document.querySelector('div[stamprdv="'+e[i].date_time_rdv+'"]').classList.add('disabled');
				}
			if(e[i].allday == 1 ) {
				
				if( document.querySelector("div[stampday='"+getDayFromStampRdv( e[i].date_time_rdv )+"']") ) { document.querySelector("div[stampday='"+getDayFromStampRdv( e[i].date_time_rdv )+"']").classList.add('disabled'); }
			}
		}*/
	},
	testSelectedRdv: function() {
		jQuery(".btn-select-hour").removeClass('selected');
		jQuery("div[stamprdv='"+wprdvModule.data.rdvStamp+"']").addClass('selected');
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
var comboBoxPerson = {
	///personListe
	selectPerson: function(e){
		//alert(e.target.value);
		/*console.log(e.target.value);*/
		wprdvModule.removeRdvRequest();
		wprdvModule.data.personId = e.target.value;
		/*this.loadList;*/
		//alert('appel de la liste des rdv de : '+wprdvModule.personId);
		m.request({
            method: "GET",
            url: window.location.href,
            data: { wprdv_person_id:e.target.value}
        })
        .then(function(result) {
			//User.list = result.data
			console.log('------');
			console.log(result);
			wprdvModule.data.rdvListFromPersonSelected = result;
			///document.tester.testBookedRdv();
			result.map(function(item){
				if(item.allday == "1") wprdvModule.data.bookedDays.push( getDayFromStampRdv( item.date_time_rdv ) )
			})
        })
		/* 
        m.request({
		    method: "PUT",
		    url: "/api/v1/users/:id",
		    data: {id: 1, name: "test"}
		})
		.then(function(result) {
		    console.log(result)
		})
		*/
		console.log('request');

	},
	view: function(vnode){
		return m('select' , { onchange:this.selectPerson } ,
			m('option', { value:null } , 'Choisissez une personne' ),
			//personListe.unshift([])
			personListe.map(function(item){
				return m('option', { value:item.person_id } , item.person_firstName+' '+item.person_lastName );
			})
		); /* [ m('option', {} , 'element 1') ])*/
	}

}
////////////////  message de conformation
var viewConfirmation = {
	oninit: function() {

	},
	oncreate: function() {

	},
	view: function() {
		return m('div', { class:'confirm-container'}, [
			"Demande de RDV bien prise en compte"
		]);
	}
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////
var wprdvModule = {
	formValid:false,
	data: {
		personId:null,
		personString:null,
		rdvString:0,
		rdvStamp:0,
		rdvDayDate:0,
		step:1,
		firstDateDisplayed:null,
		rdvListFromPersonSelected:[],
		name:"",phone:"",email:"",message:"",
		datesDisplayed:[],
		bookedDays: [],
		dateObj:new Date().toISOString().replace("T"," ").substr(0 , ).slice(0,-5)
	},
	oninit: function(){
		var d = new Date();
		console.log(d);
		d.setDate( d.getDate() );
		console.log(d);
		wprdvModule.data.datesDisplayed[0] = d;
		wprdvModule.data.datesDisplayed[1] = new Date(stampToday).setDate( d.getDate()+1  );
		wprdvModule.data.datesDisplayed[2] = new Date(stampToday).setDate( d.getDate()+2 );
		console.log( wprdvModule.data.datesDisplayed );
	},
	setName: function(param) { wprdvModule.data.name=param  },
	setEmail: function(param) { wprdvModule.data.email=param  },
	setMessage: function(param) { wprdvModule.data.message=param },
	setPhone: function(param) { wprdvModule.data.phone=param },
	removeRdvRequest: function(){
		this.data.rdvString = 0;
		this.data.rdvStamp = 0;
		
		document.tester.testSelectedRdv();
	},
	reinit: function() {
		this.data = {
			personId:null,
			personString:null,
			rdvString:0,
			rdvStamp:0,
			rdvDayDate:0,
			step:1,
			firstDateDisplayed:stampToday,
			rdvListFromPersonSelected:[]
		}
	},
	checkFormDatas: function() {

	},
	sendForm:function() {
		
	},
	onbeforeupdate:function(){;
		var d = new Date(this.data.rdvStamp*1000);
		this.data.rdvDayDate = new Date( d.getMonth()+' '+d.getDate()+' '+d.getFullYear() ).getTime()/1000;
		console.log(this.data.rdvDayDate);
		this.checkFormDatas();	
	},
    view: function() {

        return m("div", [
			m("h1", {class: ""}, "WP RDV "),
			
 			//// generation des colonne de selection des heures
			(this.data.step==1) ? m(comboBoxPerson) : null,
			m("div", {class: ""}, "> "+this.data.personId),

			(this.data.personId!=null && this.data.step == 1 ) ? m(listeHoursDOM) : null,
			m("div", {class: ""}, "> "+this.data.rdvString),

			(this.data.step==2 || this.data.step == 3 ) ? m(form) : null,

			(this.data.step==3) ? m(viewConfirmation) : null ,
        ])
    }
}

//// injection du composant principal dans le DOM
var root = document.getElementById('App');
m.mount(root, wprdvModule);