/// var used :  stampToday : today date generate in PHP class.client.php
var months = ['01','02','03','04','05','06','07','08','09','10','11','12'];
var daysStr = ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'];
var monthsStr = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];

function verifMail(chaine) {
    var exp=new RegExp("^[a-zA-Z0-9\-\_\+.]{0,256}[@]{1}[a-zA-Z0-9\-\_\+.]{0,256}[.]{1}[a-zA-Z]{0,3}$","g");
    if ( exp.test(chaine) ){ return true; }
    else { return false; }
}
function verifPhone(chaine){
	var exp=new RegExp("^[0-9]{0,10}$","g");
    if ( exp.test(chaine) ){ return true; }
    else { return false; }
}
function stampTimeToLocalString(stamp) {
	var g = new Date( parseInt(stamp) );
	var st = parseInt(stamp);
	st = st + ( (g.getTimezoneOffset()/60)*3600*1000 );
	return new Date(st).toTimeString().substr(0,5).replace(':','h');
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
var calendar = {
	today:new Date(Date.now()),
	firstDateToDisplay:new Date(Date.now()),
	datesToDisplay:[],
	dayType:{
		stampStart:null,
		stampEnd:null,
		stampDuring:null,
		pausesListe:[],
		avalablesRdv:[]
	},
	defineDayType: function(e){
		console.log(this);
		//alert('define day type');
		var now = new Date();
		calendar.today = calendar.firstDateToDisplay = new Date( now.getUTCFullYear(), now.getUTCMonth() , now.getUTCDate() , 0 , 0 , 0 );
		var p = wprdvModule.state.personSelected;
		//console.log(p.pauses);
		//var stampZeroHeure = new Date( this.today.getUTCFullYear()+' '+(this.today.getUTCMonth()+1)+' '+this.today.getUTCDate()+' 00:00:00'  ).getTime();
		this.dayType.stampStart		=  	new Date( Date.UTC(1970, 0, 1, p.day_h_start.split(':')[0],p.day_h_start.split(':')[1],0) ).getTime(); //new Date( this.today.getUTCFullYear()+' '+(this.today.getUTCMonth()+1)+' '+this.today.getUTCDate()+' '+p.day_h_start+':00'  ).getTime() - stampZeroHeure;
		this.dayType.stampDuring 	= 	new Date( Date.UTC(1970, 0, 1, p.rdv_during.split(':')[0],p.rdv_during.split(':')[1],0) ).getTime(); //new Date( this.today.getUTCFullYear()+' '+(this.today.getUTCMonth()+1)+' '+this.today.getUTCDate()+' '+p.rdv_during+':00'  ).getTime() - stampZeroHeure;
		this.dayType.stampEnd 		= 	new Date( Date.UTC(1970, 0, 1, p.day_h_end.split(':')[0],p.day_h_end.split(':')[1],0) ).getTime(); //new Date( this.today.getUTCFullYear()+' '+(this.today.getUTCMonth()+1)+' '+this.today.getUTCDate()+' '+p.day_h_end+':00'  ).getTime() - stampZeroHeure;
		var pList = JSON.parse(p.pauses);
		t = this.today;
		obj = this;
		pList.map(function(item){
			var pauseStart 	= new Date(Date.UTC(1970, 0, 1, item.start.split(':')[0],item.start.split(':')[1],0)).getTime();//new Date( t.getUTCFullYear()+' '+(t.getUTCMonth()+1)+' '+t.getUTCDate()+' '+item.start+':00'  ).getTime() - stampZeroHeure;
			var pauseEnd 	= new Date(Date.UTC(1970, 0, 1, item.end.split(':')[0],item.end.split(':')[1],0)).getTime();//new Date( t.getUTCFullYear()+' '+(t.getUTCMonth()+1)+' '+t.getUTCDate()+' '+item.end+':00'  ).getTime() - stampZeroHeure;
			obj.dayType.pausesListe.push( pauseStart+'|'+pauseEnd );
		});
		var hRdv = this.dayType.stampStart;
		//console.log(hRdv);
		this.dayType.avalablesRdv = [];
		do {
			//alert(this.today);
			hStart 	= this.today.getTime()+hRdv;
			hEnd 	= hStart+this.dayType.stampDuring;
			var customClass='';
			this.dayType.pausesListe.map(function(item){
				if(customClass!="pause"){
					customClass = (hRdv>=parseInt(item.split('|')[0]) &&  hRdv<parseInt(item.split("|")[1]) ) ? "pause" : "avalable" ;
				}
				
			});
			//console.log( hRdv );
			this.dayType.avalablesRdv.push( '{"hStart":"'+hStart+'","hEnd":"'+hEnd+'","customClass":"'+customClass+'","stamp":"'+hRdv+'"}' );
			hRdv+=this.dayType.stampDuring;
		}
		while( hRdv < this.dayType.stampEnd );

		calendar.datesToDisplay = [];
		/// if days_displayed is 7, a week is displayed. Then first day is monday, not current day.
		var dif = new Date( wprdvModule.state.today.getTime() ).getDay()-1; // day index in a week (first day is sunday) (we substract 1 to start on monday )

		for(i=0-dif; i<p.days_displayed-dif; i++){
			var newDate = new Date( wprdvModule.state.today.getTime() );
			newDate.setDate(newDate.getDate()+i);
			console.log(newDate.getTimezoneOffset());
			///alert( newDate.getDay() );
			var d =  (function(e){  return new Date(e.setUTCDate( e.getUTCDate() ))  })(  new Date( newDate.getUTCFullYear(), newDate.getUTCMonth() , newDate.getUTCDate() ,0 ,0 ,0  ) );
			//console.log( d.toLocaleString() );
			calendar.datesToDisplay.push(d);
		}
		
	},
	oninit: function(vnode){
		this.defineDayType();
	},
	onbeforeupdate: function(){
		this.defineDayType();
	},
	onupdate: function(vnode){
		//this.defineDayType();
	},
	convertToLocalTime: function(stamp){
		var st = parseInt(stamp);
		st = st + ( (g.getTimezoneOffset()/60)*3600*1000 );
		return new Date(st).toTimeString().substr(0,5).replace(':','h');
	},
	view: function() {
		var cal =this;
		return m('div', { class:"days-column days-column--"+this.datesToDisplay.length} , 
			
			this.datesToDisplay.map(function(item , index){
				//console.log(item);
				var dayDate = new Date(item);
				return m('div', {class:"day-column"}, 
					m('div',{class:"column-header"} , daysStr[dayDate.getDay()]+' '+dayDate.getDate()+' '+monthsStr[dayDate.getMonth()].substr(0,3) /*+' '+dayDate.getFullYear()*/),
					cal.dayType.avalablesRdv.map(function(item) {
						var t = JSON.parse(item);
						//console.log(item);
						stString = stampTimeToLocalString( t.stamp );
					
						var stamp = (parseInt(dayDate.getTime())+parseInt(t.stamp));
						console.log( "stamp :"+stamp/1000+" "+wprdvModule.state.bookedRdv.indexOf((stamp/1000).toString())   );
						if (wprdvModule.state.bookedRdv.indexOf((stamp/1000).toString())>-1) t.customClass+=' booked';
						return m('div' , { class:'btn-rdv '+t.customClass , stamp:stamp, dateRdv:dayDate.getFullYear()+' '+(dayDate.getMonth()+1)+' '+dayDate.getDate()+' '+stString.replace('h',':')+':00' , onclick:wprdvModule.selectRdv } , stString )
					})
				)
			})
			
		)
	}

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
var form = {
	data: {
		firstname:null,
		lastname:null,
		email:null,
		phone:null,
		message:null
	},
	setFirstName: function(param) { form.data.firstname=param  },
	setLastName: function(param) { form.data.lastname=param  },
	setEmail: function(param) { form.data.email=param  },
	setPhone: function(param) { /*if( "0123456789".indexOf(param.split('').pop() )>-1 )*/ form.data.phone=param },
	setMessage: function(param) { form.data.message=param },
	setClass: function(e){
		e.target.classList.remove('error');
	},
	checkFields: function(e) {
		var inputs = (  e.target.tagName == "BUTTON" ) ? document.querySelector('.rdv-form').querySelectorAll('input, textarea') : document.querySelectorAll('[name='+e.target.getAttribute("name")+']');
		var error = 0;
		inputs.forEach(function(input){
			(input.value.length==0) ? input.classList.add('error') : input.classList.remove('error');
			switch(input.getAttribute('name')) {
				case 'email' :
					( verifMail(input.value) == false  ) ? input.classList.add('error') : input.classList.remove('error');
				break;
				case 'tel' :
					(verifPhone(input.value)==false)  ? input.classList.add('error') : input.classList.remove('error');
				break;  
			}
			error += (input.classList.contains('error')) ? 1 : 0;
		});
		return (error==0) ? true : false ;
	},
	submit: function(e) {
		if(form.checkFields(e)==true){
			//wprdvModule.state.dataToSend.firstname = document.querySelector('')
			//	firstname:"toto"
			//}
			//personId:null,rdvSelected:null,firstname:null,lastname:null,phone:null,email:null,message:null,
			document.querySelector('.rdv-form').querySelectorAll('input, textarea').forEach(function(e){
				wprdvModule.state.dataToSend[e.name] = e.value;
			});
			wprdvModule.sendRdvRequest();
		}
	},
	view: function() {
		return m('form' , { name:"rdv-form" , class:"rdv-form" , enctype:"form-data" } ,
		
			m('div', { class:"rdv-field-group" } ,
				m('input',{ class:"rdv-field", onblur:this.checkFields , type:'text', value:'' , placeholder:'votre prénom' , name:'firstname' , id:'wprdv_first_name' ,
				oninput: m.withAttr("value", form.setFirstName), value:form.data.firstname  } ),
				m('div' , {class:'field-error-message'} , "Vous devez renseigner votre prénom." )
			),
			m('div', { class:"rdv-field-group" } ,
				m('input',{ class:"rdv-field", onblur:this.checkFields , type:'text', value:'' , placeholder:'votre nom' , name:'lastname' , id:'wprdv_last_name' ,
				oninput: m.withAttr("value", form.setLastName), value:form.data.lastname } ),
				m('div' , {class:'field-error-message'} , "Vous devez renseigner votre nom." )
			),
			m('div', { class:"rdv-field-group" } ,
				m('input',{ class:"rdv-field", onblur:this.checkFields , type:'text', value:'' , placeholder:'votre email' , name:'email' , id:'wprdv_email' ,
				oninput: m.withAttr("value", form.setEmail), value:form.data.email} ),
				m('div' , {class:'field-error-message'} , "Votre adresse email semble incomplète ou incorrecte.." )
			),
			m('div', { class:"rdv-field-group" } ,
				m('input',{ class:"rdv-field", onblur:this.checkFields , type:'text', value:'' , placeholder:'votre numéro de téléphone', maxlength:"10" , name:'phone' , id:'wprdv_tel',
				oninput: m.withAttr("value", form.setPhone), value:form.data.phone } ),
				m('div' , {class:'field-error-message'} , "Votre numero semble incomplet ou incorrect." )
			),
			m('div', { class:"rdv-field-group" } ,
				m('textarea',{ class:"rdv-field", onblur:this.checkFields, onkeyup:this.checkFields , value:'', placeholder:'La raison de votre rendez-vous.' , name:'message' , id:'wprdv_message' ,
				oninput: m.withAttr("value", form.setMessage), value:form.data.message } ),
				m('div' , {class:'field-error-message'} , "Précisez la raison de votre rendez-vous." )
			),
			m('div', { class:"rdv-field-group" } ,
			
				m('button' , { type:"button", class:"rdv-button" , onclick:this.submit  }, "ENVOYER" )
			
			)
		)
	}
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////

var wprdvModule = {
	step:1,
	formValid:false,
	bookedRdv:[],
	state: {
		personListe:null,
		personSelected:null,
		today: new Date(),
		dataToSend:{
			personId:null,rdvSelected:null,selectedRdvString:null,firstname:null,lastname:null,phone:null,email:null,message:null,
		}
	},
	oninit: function(vnode){

		d = new Date();
		day = d.getDate();
		month = parseInt(d.getMonth())+1;
		year = d.getFullYear();

		m.request({
			method: "GET",
			url: './admin-ajax.php',
			data: { action: 'getPersonsConfigs' }
		})
		.then(function(result) {
			wprdvModule.state.personListe = result;
			if(result.length == 1 ) wprdvModule.loadDateSelector(0);
			console.log( result );
		})
	},
	checkFormDatas: function() {

	},
	sendForm:function() {
		
	},
	onbeforeupdate:function(){
		
	},
	onupdate:function(){
		this.setSelectedRdvDisplay();
	},
	navbackStep : function() {
		wprdvModule.step-=1;
	},
	loadDateSelector: function(e) {
		if(wprdvModule.state.personListe!=null){
			/// get RDV list of selected person  //getFuturRdvByPerson
			m.request({
				method: "GET",
				url: './admin-ajax.php',
				data: { action: 'getFuturRdvByPerson', person_id: wprdvModule.state.personListe[ (e.target) ? e.target.value : e ]['person_id'] }
			})
			.then(function(result) {
				console.log('Booked RDV liste :');
				console.log(result);
				if(result.length > 0 ) wprdvModule.state.bookedRdv = result;
				wprdvModule.state.personSelected = wprdvModule.state.personListe[ (e.target) ? e.target.value : e ];
				wprdvModule.state.dataToSend.personId = wprdvModule.state.personSelected.person_id;				
			});
		}
	},
	nextWeek: function(vnode) {
		wprdvModule.state.today = new Date(wprdvModule.state.today.getTime()+86400000*7);
	},
	prevWeek: function() {
		wprdvModule.state.today = new Date(wprdvModule.state.today.getTime()-86400000*7);
	},
	selectRdv: function(e){
		
		if(e.target.classList.contains('selected') ) {	wprdvModule.state.dataToSend.rdvSelected = null; }
		else if( e.target.classList.contains('pause') == false && e.target.classList.contains('booked')== false ){
			//var d = e.target.getAttribute('stamp');
			//var r = new Date( parseInt(d) );
			var d = e.target.getAttribute("dateRdv");
			var r = new Date(d);
			//alert( r.getTimezoneOffset() );
			//alert(e.target.getAttribute('stamp'));
			wprdvModule.state.dataToSend.rdvSelected = e.target.getAttribute('stamp');//new Date(d).getTime();;
			//alert(d.getTime());
			wprdvModule.state.dataToSend.selectedRdvString = new Date(d).toLocaleString().replace(":","h").substr(0,18);
			wprdvModule.state.dataToSend.selectedRdvStringForDB = new Date(d).toISOString().replace('T',' ').substr(0,17)+':00';//    .2018-11-12T11:00:08.954Z()
			//alert( wprdvModule.state.dataToSend.selectedRdvString +' '+   new Date(wprdvModule.state.dataToSend.rdvSelected).getTime());
		}
		wprdvModule.setSelectedRdvDisplay();
	},
	setSelectedRdvDisplay: function(){
		document.querySelectorAll('.btn-rdv').forEach(function(e) {
			e.classList.remove('selected') ;
		});
		//console.log( document.querySelector('div[stamp="'+wprdvModule.state.dataToSend.rdvSelected+'"]') );
		if( document.querySelector('div[stamp="'+wprdvModule.state.dataToSend.rdvSelected+'"]') ) document.querySelector('div[stamp="'+wprdvModule.state.dataToSend.rdvSelected+'"]').classList.add('selected');
	},
	validRdvChoice: function(){
		wprdvModule.step = 2;
	},
	sendRdvRequest: function(){
		//alert('expedition du formulaire');
		//
		m.request({
            method: "GET",
            url: "./admin-ajax.php",
            data: { rdvDatas:wprdvModule.state.dataToSend , action: 'newRdvRequest'}
        })
        .then(function(result) {
			console.log('Retour webservice :');
			console.log(result);
			wprdvModule.formValid = (result == 1) ?  1 : 0;
        })

		
	},
    view: function() {
        return m("div", [
			m("h1", {class: ""}, "WP RDV "),
			(wprdvModule.step>1) ? m('div', {class:"wprdv-navbar"},
				m('div',{} , "Votre rendez-vous : "+wprdvModule.state.dataToSend.selectedRdvString  ),
				m('div', { onclick:this.navbackStep } ,"Modifier" ),
			) : '',
			(wprdvModule.step==1) ? m('div', {id:"wprdv-step2"} , 
				(wprdvModule.state.personListe != null) ? m('select', { id:"wprdv_personSelect", onchange:wprdvModule.loadDateSelector  },
					wprdvModule.state.personListe.map(function(item, index){
						return m('option', { value:index }, item.person_firstName+' '+item.person_lastName )
					})
				) : '',
				m('div' , {} ,
					m('button',{onclick:this.prevWeek }, '<'),
					m('button',{onclick:this.nextWeek }, '>')
				),
				(wprdvModule.state.personSelected!=null) ? m(calendar) : "",
				m('div', {} ,
					(wprdvModule.state.dataToSend.rdvSelected!=null) ? m('button', { type:'button', onclick:wprdvModule.validRdvChoice  } ,'OK' )
					: m('button', { type:'button', disabled:"disabled" } ,'OK' )
				),
			) : '',
			m('div', {id:"wprdv-step2"} , 
			
				(wprdvModule.step==2  && wprdvModule.formValid!=1) ? m(form) : '',
				(wprdvModule.formValid==1) ? m('div', { class:'wprdv_ConfirmBlock'  } , 'Votre demande à bien été prise en compte' ) : ''
				
			)
        ])
    }
}

//// injection du composant principal dans le DOM
var root = document.getElementById('App');
m.mount(root, wprdvModule);