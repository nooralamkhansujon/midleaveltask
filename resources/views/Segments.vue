@extends('welcome')

@section('content')
<style>
 .hide{
     display:none
 }
</style>
<div class="container my-5" id="subscribe_app">
   <form action="" method="post">
    <div class="row">
        <div class="col-md-4">
            <label for="">Sagment Name</label>
        </div>
        <div class="col-md-8">
            <input type="text" placeholder="Enter Segment Name" class="form-control" name="segment_name">
        </div>
    </div>
    <div class="row my-2">
        <div class="col-md-4">
            <label for="rules">Sagment Logic</label>
        </div>
        <div class="col-md-8">
          <div id="form_content" class="my-2">
             <div  class="single_content my-2" :key="index" v-for="(column,index) in columns">
                <div class="row">
                    <div class="col-md-3 my-2">
                       <input name="column_name" :value="column" disabled class="form-control column_name" id="column_name"  />
                    </div>
                    <div class="col-md-3 my-2">
                       <select name="column"   @change="setRule($event.target.value,column)" class="form-control logic_options" id="logic_options">
                           <option :value="logic"  v-if="hasDateLogicColumn(column)" v-for="(logic,index) in logicForDateField" :key="index">@{{logic}}</option>
                           <option :value="logic" else  v-for="(logic,index) in logicForTextField" :key="index">@{{logic}}</option>
                       </select>
                    </div>
                    <div class="col-md-3 my-2">
                        <input type="date"  v-if="hasDateLogicColumn(column)" @input="setValue($event,column)"  class="form-control" placeholder="Enter value">
                       <input type="text" @input="setValue($event,column)"   v-else class="form-control" placeholder="Enter value">
                    </div>
                    <div class="col-md-3 my-2">
                         <button><span><i class="fas fa-trash"></i></span></button>
                        <button class="btn btn-sm btn-primary"  @click.prevent="setRule('or',column)">+or</button>
                        <button class="btn btn-sm btn-primary"  @click.prevent="setRule('and',column)">+and</button>
                        {{-- <input type="hidden" disabled vlaue="or" class="or">
                        <input type="hidden" disabled vlaue="or" class="and"> --}}
                    </div>
                </div>
             </div>
          </div>
          <button  id="add" class="btn btn-success add">Add</button>
        </div>
    </div>

   </form>
</div>

@endsection


@section('js')
<script src="https://unpkg.com/vue@next"></script>
<script type="text/javascript">
  
   $(document).ready(function(){
       const {createApp} = Vue;
       const App   = {
           data(){
               return {
                   columns:['first_name','last_name',"email",'birth_day','created_at','updated_at'],
                   logicForTextField:['is','is_not','starts_with','ends_with','contains','doesnot_starts_with','doesnot_end_with','doesnot_contains'],
                   logicForDateField:['before','on','after','on_or_before','on_or_after','between'],
                   selectedDateLogics:false,
                   form:{
                       first_name:{search:[],rule:[],option:[]},
                       last_name:{search:[],rule:[]},
                       email:{search:[],rule:[]},
                       birth_day:{search:[],rule:[]},
                       created_at:{search:[],rule:[]},
                       updated_at:{search:[],rule:[]}
                   },
               }
           },
           watch:{
               selectedDateLogics(newVal,oldVal){
                    console.log(newVal+'new value',oldVal+'old value');
                    $( ".datepicker" ).datepicker();
               }
           },
           computed:{
               hasDateLogic(){
                   console.log(this.selectedLogics.some(logic=>logic=='on'),'running from computed')
                   return !!this.selectedLogics.some(logic=>logic=='on')
               },
               hasDateLogicColumn(){
                   return (column)=>{
                       console.log(column,'this is running ')
                       if(column == 'created_at' || column == 'updated_at' || column == 'birth_day'){
                            $( ".datepicker" ).datepicker();
                            this.selectedDateLogics = true;
                            return true;
                       } 
                       else return false;

                   };
               },
               selectLogicsRow(){
                   return (column)=>{
                       if(column == 'created_at' || column == 'updated_at' || column == 'birth_day'){
                           this.selectedLogics = this.logicForDateField
                       }else{
                           this.selectedLogics = this.logicForTextField
                       }
                        
                   }
               }
           },
           methods:{
               setLogicField(event){
                   console.log(event.target.value,'this is running');
                   let column = event.target.value;
                   if(column === 'first_name' || column =="last_name" || column == 'email'){
                       this.selectedLogics = this.logicForTextField;
                   }else{
                       this.selectedLogics = this.logicForDateField
                   }
               },
            //    setValue($event,column){
            //        let value = $event.target.value;
            //        console.log(column);
            //        if(this.form[column].search.length == 0){
            //             this.form[column].search.push(value);
            //        }
            //        //if index already  exist then 
            //        if(this.form[column]?.search.find(item=>item == value)){
            //           let checkValueIndex = this.form[column].search.findIndex(item=>itemvalue);
            //           if(this.form[column].rule[checkValueIndex] == 'or' || this.form[column].rule[checkValueIndex] == 'and' ){
            //                   this.form[column].search.push(value);
            //           }else{
            //               this.form[column].search[checkValueIndex] = value;
            //           }
            //        }
            //       //    if index doesnt exists then 
            //        else{
            //          this.form[column].search.push(value);
            //        }
            //        console.log(this.form)
            //    },
               setRule(value,column){
                //    console.log(value,column+'from rule')
                //    this.form[column].rule.push(value);
                //    console.log(this.form);
               }
           },
           mounted(){
                let $datepicker = $(".datepicker");
                $.each($datepicker,function(value,data){
                    console.log(data);
                    $(data).datepicker();
                })
                console.log($(".datepicker"));
           }
       }
       const app  = createApp(App);
       app.mount('#subscribe_app');
        var form_content  = document.querySelector('#form_content');

        console.log(form_content)
        function addNewInput(e){
            e.preventDefault();
            let divElement = document.createElement('div');
            divElement.classList.add('single_content','my-2')
            let text   = `<div class="row"><div class="col-md-3 my-2">
                             <select name="column_name" class="form-control column_name" id="column_name">`
            for(let column in  columns){
                text  += `<option value="${column}">${columns[column]}</option>`;
            }
            text +=`</select></div>
                    <div class="col-md-3 my-2">
                    <select name="logic" class="form-control logic_options" id="logic_options">`  
          for(let value of  logicForDate){
            text  += `<option value="${value}">${value.toUpperCase()}</option>`;
         } 
                               
        text+= `</select></div>
                <div class="col-md-3 my-2">
                    <input type="text" name="value" class="form-control column_value datepicker" id="value" placeholder="Enter value">
                </div>
                            <div class="col-md-3 my-2">
                                <button><span><i class="fas fa-trash"></i></span></button>
                                <button class="btn btn-sm btn-primary">+or</button>
                                <button class="btn btn-sm btn-primary">+and</button>
                                <input type="hidden" disabled vlaue="or" class="or">
                                <input type="hidden" disabled vlaue="or" class="and">
                            </div>
                        </div>`;
            divElement.innerHTML =text;
            console.log(form_content);
            form_content.appendChild(divElement);
        }
 
        let addButton = document.querySelector('#add');
        addButton.addEventListener('click',addNewInput);
   })
</script>
@endsection
