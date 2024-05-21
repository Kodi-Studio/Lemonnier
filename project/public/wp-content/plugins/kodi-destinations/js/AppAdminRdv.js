var months = ['01','02','03','04','05','06','07','08','09','10','11','12'];

var monthsStr = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];

var today = new Date();

function getNumberOfDays(year, month) {
    var days = 31;
    var currentDate = new Date(year, month, days);
    var itsOk = false;

    do {
        if (currentDate.getDate() < 28) {
            // La date est passée au mois suivant
            days--;
            currentDate = new Date(year, month, days);
        } else {
            itsOk = true;
        }
    }  while (!itsOk);
    return currentDate.getDate();
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

	var stringDay = (date<10) ? '0'+date : date;

	var time =  stringDay + '/' + month + '/' + year + ' à ' + hour + ':' + min ;
	return time;
}
//////////

var btnSelectRdv = {
	//// composant bouton de sélection des heures
	data: {

	},
	selectHour: function(e){
		/*if(!jQuery(e.target).hasClass('disabled') ){
			if(!jQuery(e.target).hasClass('selected') ) {
				rdvString =  timeConverter( e.target.getAttribute("stamprdv") ); //  e.target.getAttribute("stamprdv");
				rdvStamp = e.target.getAttribute("stamprdv");
				wprdvAdminModule.data.rdvString = rdvString;
				wprdvAdminModule.data.rdvStamp = rdvStamp;
			}else{
				wprdvAdminModule.data.rdvString = 0;
				wprdvAdminModule.data.rdvStamp = 0;
			}
			document.tester.testSelectedRdv();			
		}*/
	},
	oninit: function(vnode) {
		//this.data = wprdvAdminModule.data;
		//console.log(this.data.rdvString);
		this.isBooked();
	},
	isBooked: function() {

	},
	view: function(item) {
		var e = item.attrs;
		return m('div' , { 	
							class:e.class,
							/*stampday :e.stampday, 
							stamphour:e.stamphour,*/
							stamprdv:e.stamprdv, 
							hour:e.hour,
							min:e.min,
							onclick:datepicker.setHour,
						} , e.text )
	}
}

var colmunDay = {
	/////// composant colonne de sélection des heures
	saveNewRdv: function(vnode){
		console.log(datepicker.data);
		datepicker.data.rdvObject.date = new Date(datepicker.data.date.getMonth()+' '+datepicker.data.date.getDate()+' '+datepicker.data.date.getFullYear()+' 0:0:0').getTime()/1000;
		datepicker.data.rdvObject.date_time_rdv = Math.round(datepicker.data.date.getTime()/1000); 
		datepicker.data.rdvObject.allday = (alldayChecker.data.checked == true) ? 1 : 0;
		datepicker.data.rdvObject.name = comboBoxPerson.data.person_Name; 
		datepicker.data.rdvObject.mail = comboBoxPerson.data.person_Mail; 

		//// requete AJAX vers serveur pour sauvegarde en DB
		m.request({
            method: "GET",
            url: "./admin-ajax.php", //window.location.href,
            data: { wprdv_new_adminrdv:datepicker.data.rdvObject , action: 'newRdvAdmin'}
        })
        .then(function(result) {
			console.log('Retour webservice------');
			console.log(result);
			comboBoxPerson.selectPerson( comboBoxPerson.data.vnodeTarget );
			alldayChecker.reset();
			
        })
	},
	view: function(vnode) {
		
		var dateDay = datepicker.data.date; //wprdvModule.data.firstDateDisplayed+(vnode.attrs.index * 86400);
		/// on defini la date du jour (sans heures) pour savoir si la journée à été bloquée
		var d = new Date(dateDay);
		d = new Date( d.getMonth()+' '+d.getDate()+' '+d.getFullYear() +" 00:00:00" ).getTime()/1000;
		console.log("d--> "+d);
		console.log( wprdvAdminModule.data.bookedDays.indexOf( d.toString() ) >= 0 );
		datepicker.data.allDay =  ( wprdvAdminModule.data.bookedDays.indexOf( d.toString() ) >= 0) ? true :  false ;

		return m('div',
			{ class:'selector-hours--hours' } ,
				m('div', {class:'selector-hours-headerDay'}, dateDay.getDate()+' '+monthsStr[dateDay.getMonth()]+' '+dateDay.getFullYear()  ),
				rdvTimes.map(function(hour){
					d = datepicker.data.date;
					/*var booked = ""; (vnode.attrs.s.indexOf(parseInt(dateDay.getTime())+parseInt(hour.split('|')[2]))>-1)  ? "btn-select-hour  disabled" : "btn-select-hour ";
					
					var stampHour = hour.split('|')[2];*/
					var stampRdv = new Date( d.getFullYear()+' '+(d.getMonth()+1)+' '+d.getDate()+' '+hour.split('|')[0] ).getTime() /1000;
					//var booked = dayBookedCSS;
					booked = (wprdvAdminModule.data.rdvStampListe.indexOf(stampRdv.toString())  >-1 || datepicker.data.allDay==true  ) ? "btn-select-hour  disabled" : "btn-select-hour ";
					
					return m(btnSelectRdv, {
						class: booked,
						/*dateDay :  dateDay.getTime(), 
						stamphour:stampHour,*/
						stamprdv: stampRdv,
						hour: hour.split('|')[0].split(':')[0],
						min: hour.split('|')[0].split(':')[1],
						text: hour.split('|')[0]+' - '+hour.split('|')[1]
					})
					
				}),
				( datepicker.data.allDay==false ) ? m(alldayChecker) : '',
				(alldayChecker.data.modified == true) ? m('button', { onclick:this.saveNewRdv } , "enregistrer" ) :' ' ,
				m('div' , { }, d.toString() )
			)
	}
}

var alldayChecker = {
	data: {
		checked:false,
		modified:false
	},
	reset: function(){
		alldayChecker.data.modified = false;
		alldayChecker.data.checked = false;
	},
	toggle:function(vnode){
		//if(datepicker.data.allDay !=  -1 ) {
			//alldayChecker.data.checked = (alldayChecker.data.checked == true ) ? false : true ;
			if(alldayChecker.data.checked == true ){
				alldayChecker.data.checked = false;
			}else{
				alldayChecker.data.checked = true; datepicker.setAlldayhour();
			}
			alldayChecker.data.modified =true;
		//}
		
	},
	view: function(vnode) {
		return m('div', {class:"selector-allday"} , 
			m('label', {} ,
				m('span', {} , "journée complète : " ),
				m('input', { type:"checkbox", oninput:this.toggle , checked:this.data.checked  })
			)
		);
	}
}
//////////
var comboBoxPerson = {
	data:{
		person_Id:null,
		person_Name:null,
		person_Mail:null,
		vnodeTarget:null
	},
	///personListe
	selectPerson: function(vnode){
		wprdvAdminModule.data.personId = vnode.target.value;
		comboBoxPerson.data.person_Id = vnode.target.value;
		comboBoxPerson.data.person_Name = vnode.target.options[vnode.target.selectedIndex].getAttribute('person_name');
		comboBoxPerson.data.person_Mail = vnode.target.options[vnode.target.selectedIndex].getAttribute('person_mail');
		console.log(vnode.target.options[this.selectedIndex]);
		console.log(this);
		comboBoxPerson.data.vnodeTarget = vnode;

		m.request({
            method: "GET",
            url: "./admin-ajax.php", //window.location.href,
            data: { wprdv_person_id:vnode.target.value , action: 'rdvlisteAdmin'}
        })
        .then(function(result) {
			console.log('Retour webservice------');
			console.log(result);
			wprdvAdminModule.data.rdvListFromPersonSelected = result;
			wprdvAdminModule.data.bookedDays = wprdvAdminModule.data.rdvStampListe = [];
			wprdvAdminModule.data.rdvListFromPersonSelected.map(function(item){
				/// liste des rdv en timestamp
				wprdvAdminModule.data.rdvStampListe.push( item.date_time_rdv );
				/// liste des RDV avec journée bloquée
				if(item.allday == 1) wprdvAdminModule.data.bookedDays.push( item.date );
			})
        })
	},
	view: function(vnode){
		return m('select' , { onchange:this.selectPerson } ,
			personListe.map(function(item){
				return m('option', { value:item.person_id , person_name:item.person_firstName+' '+item.person_lastName , person_mail:item.person_email } , item.person_firstName+' '+item.person_lastName );
			})
		); 
	}
}

var datepicker = {
	data: {
		year:null,
		month:null,
		day:null,
		date:new Date(),
		monthNbDays:[null],
		allDay:false,
		rdvObject: {
			allday: this.allDay,
			date: this.day,
			date_time_rdv: this.date,
			message: "Journée bloquée via l'admin",
			name: "Administrateur",
			person_id: null
		}
	},
	reset: function(){
		this.data = {
			year:null,
			month:null,
			day:null,
			date:new Date(),
			monthNbDays:[null],
			allDay:false,
			rdvObject: {
				allday: this.allDay,
				date: this.day,
				date_time_rdv: this.date,
				message: "Journée bloquée via l'admin",
				name: "Administrateur",
				person_id: null
			}
		}
	},
	prevNextYear:function(e) {
		(e.target.classList=="btnNext") ? datepicker.data.date.setFullYear( datepicker.data.date.getFullYear()+1 )  :  datepicker.data.date.setFullYear( datepicker.data.date.getFullYear()-1 )  ;
		alldayChecker.reset();
	},
	prevNextMonth:function(e) {
		(e.target.classList=="btnNext") ? datepicker.data.date.setMonth( datepicker.data.date.getMonth()+1 )  :  datepicker.data.date.setMonth( datepicker.data.date.getMonth()-1 )  ;
		alldayChecker.reset();
	},
	setDay:function(e){
		datepicker.data.date.setDate(e.target.getAttribute('day'));
		datepicker.data.date.setHours( 0, 0, 0 );
		alldayChecker.reset();
	},
	oninit: function() {
		this.data.year = today.getFullYear();
		this.data.month = today.getMonth();
		this.data.day = today.getDate();
		this.setMonthNbDays();
	},
	onbeforeupdate: function() {
		this.data.rdvObject.person_id = wprdvAdminModule.data.personId;
	},
	onbeforeupdate: function() {
		this.setMonthNbDays();
	},
	onupdate: function(){
		this.data.rdvObject.person_id = wprdvAdminModule.data.personId;
	},
	setHour: function(e){
		datepicker.data.date.setHours( e.target.getAttribute('hour') , e.target.getAttribute('min') , 00 );
		alldayChecker.data.checked = false;
		alldayChecker.data.modified = true;
	},
	setAlldayhour: function(e){
		datepicker.data.date.setHours( 00 , 00 , 00 );
	},
	setMonthNbDays:function(){
		this.data.monthNbDays = [];
		var nDaysInMonth = getNumberOfDays( datepicker.data.date.getFullYear() , datepicker.data.date.getMonth());
		for( var i=1 ; i<=nDaysInMonth ; i++ ){
			this.data.monthNbDays.push( i );
		}
	},
	view: function(vnode) {

		return 	m('div', { class:"datepiker-container" } ,
					m('div', { class:"" }, 'Année :' ),
					m('div', { class:""},
						m('span', {class:"btnPrev",  onclick:this.prevNextYear} , '-'),
						m('span', {class:"year"} , this.data.date.getFullYear() ),
						m('span', {class:"btnNext", onclick:this.prevNextYear} , '+'),
					),
					m('div', { class:"" }, 'Mois :' ),
					m('div', { class:""},
						m('span', {class:"btnPrev",  onclick:this.prevNextMonth} , '-'),
						m('span', {class:"month"} , monthsStr[this.data.date.getMonth()] ),
						m('span', {class:"btnNext", onclick:this.prevNextMonth} , '+'),
					),
					m('div', { class:"datepicker-days"},
						
						this.data.monthNbDays.map(function(value) {
							return m('span', { class:"datepicker-day", day:value , onclick:datepicker.setDay },  value)
						})
					)
				)

	}
}

//	pagenow = 'toplevel_page_rdv_manager'
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
var wprdvAdminModule = {
	formValid:false,
	data: {
		personId:null,
		personString:null,
		rdvListFromPersonSelected: [],
		rdvStampListe: [],/// liste des timstamp des RDV booké pour la personne selectionnee
		bookedDays:[]
	},
	checkFormDatas: function() {

	},
	sendForm:function() {
		
	},
	updateStatut:function(e){
		var tempoRdv = wprdvAdminModule.data.rdvListFromPersonSelected[ e.target.value ];
		tempoRdv[e.target.name.split('_')[0]] = ( e.target.checked == true )? val=1 : val=0 ;
		wprdvAdminModule.updateRdv(tempoRdv, e.target.value );	
	},
	updateRdv:function(tempoRdv , index){
		console.log(tempoRdv);
		console.log(index);
		this.data.rdvListFromPersonSelected[index] = tempoRdv;
		console.log()
		console.log( this.data.rdvListFromPersonSelected[index] );
		/// si on bloque la journéee on ajoute ce RDV à la oiste des dates bloquées
		(tempoRdv.allday == 1 ) ? wprdvAdminModule.data.bookedDays.push(tempoRdv.date) : wprdvAdminModule.data.bookedDays.splice( wprdvAdminModule.data.bookedDays.splice( months.lastIndexOf( tempoRdv.date ) , 1 )  )  ;
		m.request({
            method: "GET",
            url: "./admin-ajax.php", //window.location.href,
            data: { wprdv_rdv:tempoRdv , action: 'updaterdv'}
        })
        .then(function(result) {
			wprdvAdminModule.data.rdvListFromPersonSelected[ index ] = tempoRdv;
			
        })
		//return true;
	},
	onupdate:function(){
		this.checkFormDatas();
	},
    view: function() {
		var s = JSON.stringify(wprdvAdminModule.data.rdvListFromPersonSelected);
        return m("div", [
            m("h1", {class: ""}, "Liste des RDV :"),
			m('div' , {class: "alignleft actions bulkactions" } , [m(comboBoxPerson)] ),
			m('div', {class:"liste-rdv-wrapper"} , 

				m('div' , {class:"liste-rdv-elt  liste-rdv-elt--header"} ,
					m('div',{class:"col name"}, "Nom"),
					m('div',{class:"col mail"}, "Email"),
					m('div',{class:"col phone"},"Tél"),
					m('div',{class:"col date"}, "date & heure" ),
					m('div',{class:"col allday"}, "Jour"),
					m('div',{class:"col refused"}, "refusé"),
					m('div',{class:"col confirmed"}, "Validé"),

				),
				m('div', { class:"liste-rdv-listcontainer" }, 
					this.data.rdvListFromPersonSelected.map(function(item, index){
						return m('div' , {class:"liste-rdv-elt"} ,
							m('div',{class:"col name"}, item.name),
							m('div',{class:"col mail"}, item.mail),
							m('div',{class:"col phone"},item.tel),
							m('div',{class:"col date"}, timeConverter(item.date_time_rdv) ),
							m('div',{class:"col allday"}, m('input', { type:"checkbox", onchange:wprdvAdminModule.updateStatut, name:"allday_"+item.rdv_id, value:index , checked:(item.allday ==1) ? true : false })),
							m('div',{class:"col refused"}, m('input', { type:"checkbox", oninput:wprdvAdminModule.updateStatut, name:"refused_"+item.rdv_id , value:index ,checked:(item.refused ==1) ? true : false })),
							m('div',{class:"col confirmed"}, m('input', { type:"checkbox", oninput:wprdvAdminModule.updateStatut,  name:"confirmed_"+item.rdv_id, value:index , checked:(item.confirmed ==1) ? true : false })),

						)
					})
				)
			),
			(comboBoxPerson.data.person_Id!=null && comboBoxPerson.data.person_Id != 'null' ) ?		m('div' , { } ,
					m("h1", {class: ""}, "Ajouter un RDV :"),
					m('div' , {class: "alignleft actions bulkactions" } , []),
					m('div', {class:"liste-rdv-wrapper"} , 
						m(datepicker),
						m(colmunDay , {s:s} ),
					)
				, ) : '',
        ])
    }
}

//// injection du composant principal dans le DOM
var root = document.getElementById('App');
m.mount(root, wprdvAdminModule);

