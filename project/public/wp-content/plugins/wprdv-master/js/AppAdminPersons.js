
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
var wprdvAdminModule = {
	formValid:false,
	data: {
		personListe:null,
		editProcess:null,
		personToEdit:{
			person_id:null,
			person_firstName:null,
			person_lastName:null,
			person_email:null,
			person_job:null
		}
	},
	resetDatas: function() {
		this.data = {
			personListe:null,
			editProcess:null,
			personToEdit:{
				person_id:null,
				person_firstName:null,
				person_lastName:null,
				person_email:null,
				person_job:null
			}
		}
		return true;
	},
	delete: function(vnode) {
		console.log(vnode.target.getAttribute('idp'));

		if(confirm('Confirmer vous la suppression de '+vnode.target.getAttribute('name')+' ?')) {
			m.request({
				method: "GET",
				url: "./admin-ajax.php", //window.location.href,
				data: { deletePerson_id:vnode.target.getAttribute('idp') , action: 'deletePerson'}
			})
			.then(function(result) {
				/// renvoie la liste des collaborateur emputée de celui qui à été supprimé
				wprdvAdminModule.data.personListe = result;
			})
		}
	},
	edit:function(vnode) {
		console.log(vnode);
		
		wprdvAdminModule.data.editProcess = vnode.target.getAttribute('index');
		wprdvAdminModule.data.personToEdit = wprdvAdminModule.data.personListe[ vnode.target.getAttribute('index') ];
	},
	editNew: function(vnode){
		wprdvAdminModule.data.editProcess = "new";
	},
	updateStatut:function(e){
	
	},
	setInput:function(value ){
		//wprdvAdminModule.data.personToEdit[this.label] = value;
	},
	saveModifsPerson: function(){

		if( 
			document.querySelector('input[name=person_firstName').value.length
			&& document.querySelector('input[name=person_lastName').value.length
			&& document.querySelector('input[name=person_email]').value.length
			&& document.querySelector('input[name="person_job"]').value.length

		) {
			wprdvAdminModule.data.personToEdit = {
				person_id:document.querySelector('input[name=person_id').value,
				person_firstName:document.querySelector('input[name=person_firstName').value,
				person_lastName:document.querySelector('input[name=person_lastName').value,
				person_email:document.querySelector('input[name=person_email]').value,
				person_job:document.querySelector('input[name="person_job"]').value
			};
			( wprdvAdminModule.data.editProcess!="new" ) ?  wprdvAdminModule.ajaxSave('updatePerson') : wprdvAdminModule.ajaxSave('insertPerson');
		}


		
	},
	ajaxSave: function(actionParam) {
		m.request({
			method: "GET",
			url: "./admin-ajax.php", //window.location.href,
			data: { person_datas:wprdvAdminModule.data.personToEdit , action: actionParam }
		})
		.then(function(result) {
			/// renvoie la liste des collaborateur  avec collaborateur modifié
			if(wprdvAdminModule.resetDatas() ) wprdvAdminModule.data.personListe = result;
		})
	},
	oncreate: function() {

	},
	oninit: function(){
		console.log('init -------------');
		wprdvAdminModule.data.personListe = personListe;
		personListe = [];
	},
	onupdate:function(){
		
	},
    view: function() {
		var p = wprdvAdminModule.data.personToEdit;
        return m("div", [
            m("h1", {class: ""}, "Liste des collaborateurs :"),
			m('div', {class:"liste-rdv-wrapper"} , 

				m('div' , {class:"liste-persons-elt  liste-persons-elt--header"} ,
					m('div',{class:"col lastname"}, "Nom"),
					m('div',{class:"col firstname"}, "Prénom"),
					m('div',{class:"col email"},"Email"),
                    m('div',{class:"col title"}, "Titre" ),
                    m('div',{class:"col action"}, " " ),
                    m('div',{class:"col action"}, "" )
                ),
                wprdvAdminModule.data.personListe.map(function(item, index ){
                    return (item.person_id!=null) ?  m('div' , {class:"liste-persons-elt"} ,
                        m('div', {class:"col lastname"} , item.person_lastName ),
                        m('div',{class:"col firstname"}, item.person_firstName),
                        m('div',{class:"col email"},item.person_email),
                        m('div',{class:"col title"}, item.person_job),
                        m('div',{class:"col action" },  m('span', { class:"btn" , idp:item.person_id, index:index, name:item.person_firstName+' '+item.person_lastName , onclick:wprdvAdminModule.edit }, "EDIT") ),
                        m('div',{class:"col action" },  m('span', { class:"btn" , idp:item.person_id, index:index, name:item.person_firstName+' '+item.person_nlastName , onclick:wprdvAdminModule.delete }, "SUPPR") )
                    ) : '';
				}),	
			),
			m('div', {} ,
				(wprdvAdminModule.data.editProcess!='new' && wprdvAdminModule.data.editProcess==null ) ? m('button' , { class:"btn", onclick:wprdvAdminModule.editNew  } , "Nouveau"  ) : "",
			), 
			m('div', {} , 
					(wprdvAdminModule.data.editProcess!=null ||  wprdvAdminModule.data.editProcess=='new'  ) ? m('div', {} , 
						
						m("h1", {class: ""}, "Edition :"),
						m("div" ,{class:"liste-rdv-wrapper"} ,
							m('input', { type:"hidden" , name:"person_id", value:p.person_id }  ),
							m('label', { } , ["Nom : ", 
								m('input', {type:"text", name:"person_lastName", placeholder:"nom", /*oninput: m.withAttr("value", wprdvAdminModule.setInput, {label:"person_lastName"}), */value:p.person_lastName  }) ] 
							),
							m('label', { } , ["Prénom : ", 
								m('input', {type:"text",name:"person_firstName", placeholder:"prénom", /*oninput: m.withAttr("value", wprdvAdminModule.setInput, {label:"person_firstName"}), */ value:p.person_firstName  }) ] 
							),
							m('label', { } , ["Email : ", 
								m('input', {type:"text", name:"person_email",placeholder:"E-mail", value:p.person_email  }) ] 
							),
							m('label', { } , ["Titre : ", 
								m('input', {type:"text", name:"person_job", placeholder:"Titre",  value:p.person_job }) ] 
							),
							m('div', {} , 
								m('button' , { class:"btn", onclick:wprdvAdminModule.saveModifsPerson  } , "Enregistrer"  ),
								m('button' , { class:"btn", onclick:wprdvAdminModule.resetDatas  } , "Annuler"  ),
							)

						),


					
					) : '' 
			),
			
        ])
    }
}

//// injection du composant principal dans le DOM
var root = document.getElementById('App');
m.mount(root, wprdvAdminModule);