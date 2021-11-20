@extends('welcome')

@section('content')
<style>
 .hide{
     display:none
 }
</style>
<div class="container my-5" id="subscribe_app">
   
   <form action="{{route('segment.logic.store')}}" method="post">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
         @endif
     @csrf
     <div class="row">
       <div class="col-md-12">
           <ul>
                @if(session()->has('flash_error_message'))
                    <li class="text-danger">{{session()->get('flash_error_message')}}</li>
                @endif 
                @if(session()->has('flash_success_message'))
                    <li class="text-success">{{session()->get('flash_success_message')}}</li>
                @endif 
           </ul>
           <ul>
              {{-- @if($errors->any())
                 @foreach($errors->)
              @endif  --}}
           </ul>
       </div>
       <div class="col-md-12">
           <ul>
                @if(session()->has('flash_error_message'))
                    <li class="text-success">{{session()->get('flash_error_message')}}</li>
                @endif 
           </ul>
       </div>
     </div>
    <div class="row">
        <div class="col-md-4">
            <label for="">Sagment Name</label>
        </div>
        <div class="col-md-8">
            <input type="text"  placeholder="Enter Segment Name" class="form-control" name="segment_name">
        </div>
    </div>
    <div class="row my-2"> 
        <div class="col-md-4">
            <label for="rules">Sagment Logic</label>
        </div>
        <div class="col-md-8">
          <div id="form_content" class="my-2">
             @foreach($columns as $key=>$column)
             <div  class="single_content my-2" id="single_content_{{$column->subscribers_column_name}}">
                <div class="row">
                    <div class="col-md-3 my-2">
                       <input name="{{$column->subscribers_column_name}}[]" value="{{$column->subscribers_column_name}}" disabled class="form-control column_name"  />
                     
                    </div>
                    <div class="col-md-3 my-2">
                       <select name="{{$column->subscribers_column_name}}[logic][]" class="form-control logic_options" id="logic_options">
                       @php
                         $logicField = $column->logics($column->logic_type); 
                       @endphp
                       <option selected value="" disabled>select Logic</option>
                       @foreach($logicField as $key=>$logic )
                           <option  value="{{$logic->id}}">{{$logic->logic}}</option>
                        @endforeach 
                       </select>
                    </div>
                    <div class="col-md-3 my-2">
                          <input type="{{$column->logic_type}}" name="{{$column->subscribers_column_name}}[value][]" class="form-control" placeholder="Enter value">
                    </div>
                    <div class="col-md-3 my-2" id="column_{{$column->subscribers_column_name}}">
                         {{-- <button class="delete_column" data-column="{{$column->subscribers_column_name}}"><span><i class="fas fa-trash"></i></span></button> --}}

                        <input type="hidden" id="column_{{$column->subscribers_column_name}}_options_{{$key}}" 
                        class="{{$column->subscribers_column_name}}_options_{{$key}}" name="{{$column->subscribers_column_name}}[option][]">

                        <button type="button" data-column="{{$column->subscribers_column_name}}" 
                        class="btn btn-sm btn-primary addMore" data-key="{{$key}}" data-logic_type="{{$column->logic_type}}" data-connect="or">+or</button>
                        <button type="button" data-key="{{$key}}" class="btn btn-sm btn-primary addMore" data-connect="and"
                         data-logic_type="{{$column->logic_type}}"
                         data-column="{{$column->subscribers_column_name}}">+and</button>
                      
                        
                    </div>
                </div>
             </div>
             @endforeach
          </div>
        </div>
    </div>
     <div class="row">
         <div class="col-md-4 offset-4">
            <button type="submit" class="btn btn-lg btn-success">save</button>
         </div>
     </div>
   </form>
</div>

@endsection

@section('js')
{{-- <script src="https://unpkg.com/vue@next"></script> --}}
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript">
  
   $(document).ready(function(){

       $(document).on('click','.addMore',function(e){
               e.preventDefault();
               const {target}     = e;
               let {connect,logic_type,column,key} = target.dataset; 
               const groupInput   = document.querySelector(`#column_${column}_options_${key}`);
               //if length grether then 1 then not add more 
               let updateKey = Number(key)+1;
               if(document.querySelectorAll(`.${column}_options_${updateKey}`)?.length == 0 ) {
                let mainDiv        =  document.querySelector(`#single_content_${column}`);
                single_row(mainDiv,column,logic_type,++key);
               }
                groupInput.value   = connect;
               

       });
       $(document).on('click','.delete_column',function(e){
           e.preventDefault();
           const {target,currentTarget} = e;
           const {column}               = currentTarget.dataset;
           const parentRow              = currentTarget.parentElement.parentElement;

           if(parentRow.classList.contains('row')){
              const mainSingleContent = document.querySelector(`#single_content_${column}`);
              let previousChildren    = mainSingleContent.children.length-1-1;
              mainSingleContent.removeChild(parentRow);
           }
       })
   });

   async function  getLogics(logic_type){
       let {data:{logic_types}} = await axios.get(`/logics/api/${logic_type}`);
       return logic_types;
   }
   async function single_row(main_div,column,logic_type,key){
       let div = document.createElement('div');
       div.classList.add('row');
       let innerText = `<div class="col-md-3 my-2"><input name="${column}[]" value="${column}" disabled class="form-control column_name"/></div>`;
       innerText+=`<div class="col-md-3 my-2"><select name="${column}[logic][]" class="form-control logic_options">`;
       let logic_types = await getLogics(logic_type);
       logic_types.forEach(logic=>{
            innerText +=`<option value="${logic.id}">${logic.logic}</option>`;
       });
       innerText +=`</select></div>`;
       innerText+=`<div class="col-md-3 my-2">
                    <input type="${logic_type}" name="${column}[value][]" class="form-control" placeholder="Enter value"> 
                    </div>`;
       innerText +=` <div class="col-md-3 my-2" id="column_${column}">

                     <button data-column="${column}" class="delete_column"><span><i class="fas fa-trash"></i></span></button>
                     <input type="hidden" class="${column}_options_${key}" 
                     id="column_${column}_options_${key}" name="${column}[option][]">

                     <button  data-logic_type="${logic_type}" data-key="${key}" data-column=${column} class="btn btn-sm btn-primary addMore" data-connect="or">+or</button>

                    <button  data-logic_type="${logic_type}" data-key="${key}" class="btn btn-sm btn-primary addMore" data-connect="and" data-column=${column}>+and</button>
                    </div>`;
        div.innerHTML=innerText;
        main_div.appendChild(div);
   }
</script>
@endsection
