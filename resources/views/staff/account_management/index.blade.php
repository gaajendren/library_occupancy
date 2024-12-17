<x-staff-app-layout>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/css/intlTelInput.css">


<main class="h-screen bg-slate-200 py-14 max-sm: px-5" > 
    <div class="flex flex-col  p-4 mx-8 bg-white shadow-[0px_5px_30px_20px_rgba(0,0,0,0.1)] rounded-lg mb-10">
        <button id='addUser'  data-modal-target="default-modal" data-modal-toggle="default-modal" data-action="add" class="bg-blue-500 self-end rounded-lg shadow-md float-end p-3 py-2 text-white hover:bg-blue-700">Add User</button>

        <div class="relative z-1 table-container  p-1 mx-2 overflow-x-hidden bg-white dark:bg-gray-800 dark:text-white ">
            <table id='table' class="w-full mt-10 text-sm overflow-x-hidden  text-left border-collapse border border-1 border-gray-300 rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                    
                        <th scope="col" class="px-6 py-3 border border-gray-300">
                            Full Name
                        </th>
                        <th scope="col" class="px-6 py-3 border  border-gray-300">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 border  border-gray-300">
                            Contact
                        </th>
                        <th scope="col" class="px-6 py-3 border  border-gray-300">
                            IC No
                        </th>
                        <th scope="col" class="px-6 py-3 border  border-gray-300">
                            Role
                        </th>
                        <th scope="col" class="px-6 py-3 border  border-gray-300">
                            Verifed
                        </th>
                        <th scope="col" class="px-6 py-3 border  border-gray-300">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class='overflow-x-auto'>

                    @foreach ( $users as $user)
                    <tr class="bg-white h-full dark:bg-gray-800 dark:border-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">
                        
                        <th  class="name px-6 py-4 font-medium border border-gray-300 ">
                            {{$user->name}}
                        </th>
                        <td class="email px-6 py-4 border  border-gray-300">
                            {{$user->email}}
                        </td>
                        <td class="contact px-6 py-4 border  border-gray-300">
                            {{$user->contact}}
                        </td>
                        <td class="ic px-6 py-4 border  border-gray-300">
                            {{$user->ic}}
                        </td>

                        <input type="hidden" class='address' name="address" value="{{$user->address}}">

                        <td class="role px-6 py-4 border  border-gray-300">
                            {{ $user->role == 0 ?  'Student' : 'Staff' }}
                        </td>
                        <td class="role px-6 py-4 border text-center  border-gray-300">
                            <i class="fa-solid fa-circle-{{$user->email_verified_at == null ? 'xmark' : 'check'}} fa-lg" style="color: {{$user->email_verified_at == null ? 'red' : 'green'}}" ></i>
                        </td>   
                    
                        <td class="px-6 py-4  border border-gray-300 ">
                            <div class="flex flex-row justify-center items-center gap-2">
                                <button  data-modal-target="view-modal" data-action='view' data-id='{{$user->id}}'  data-modal-toggle="view-modal" class="block text-white bg-blue-500 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-3 py-2 text-center " type="button">
                                    <i class="fa-solid fa-eye fa-sm"></i>
                                </button>
                                <button  data-modal-target="default-modal" data-action='edit' data-id='{{$user->id}}'  data-modal-toggle="default-modal" class="block text-white bg-green-500 hover:bg-green-800 focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-3 py-2 text-center " type="button">
                                    <i class="fa-solid fa-pen-to-square fa-sm"></i>
                                </button>
                                <form method="POST" action="{{ route('staff.delete.account', $user->id) }}" accept-charset="UTF-8" >
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="block text-white bg-red-500 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-3 py-2 text-center " onclick="return confirm(&quot;Confirm delete?&quot;)">
                                <i class="fa-solid fa-trash-can fa-sm"></i>
                                    </button>
                                </form>
                            
                            </div>
                        
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>  
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/js/intlTelInput.min.js"></script>

@include('staff.account_management.edit')
@include('staff.account_management.view')

<script>
    document.addEventListener('DOMContentLoaded', function (){


        document.getElementById('addUser').addEventListener('click', function(){
            document.querySelector('.title').textContent = "Add new user"
            const action_type = this.getAttribute('data-action');
           
            if(action_type == 'add'){
                console.log('pass')
                submitForm(action_type)
            } 

        })

        document.querySelectorAll('[data-action="edit"]').forEach(button => {
        button.addEventListener('click', function () {
           
            const action_type = button.getAttribute('data-action');
            const userId = button.getAttribute('data-id');
            
             const tr = button.closest('tr');

             const name = tr.querySelector('.name').textContent
             const ic = tr.querySelector('.ic').textContent
             const contact = tr.querySelector('.contact').textContent
             const address = tr.querySelector('.address').value
             const email = tr.querySelector('.email').textContent
             const role = tr.querySelector('.role').textContent

             document.getElementById('name').value = name.trim()
             document.getElementById('ic').value = ic.trim()
             document.getElementById('contact').value = contact.trim()
             document.getElementById('address').value = address.trim()
             document.getElementById('email').value = email.trim()
             document.getElementById('roles').value = role.trim()
             
             if (action_type == 'edit') {
                document.querySelector('.title').textContent = "Update user account" 
                role.trim() == 'Student' ? document.getElementById('student').selected = true : document.getElementById('staff').selected = true
                submitForm(action_type, userId)
             } 
        });
    });


    document.querySelectorAll('[data-action="view"]').forEach(button => {
        button.addEventListener('click', function () {
                 
             const tr = button.closest('tr');

             const name = tr.querySelector('.name').textContent
             const ic = tr.querySelector('.ic').textContent
             const contact = tr.querySelector('.contact').textContent
             const address = tr.querySelector('.address').value
             const email = tr.querySelector('.email').textContent
             const role = tr.querySelector('.role').textContent

             document.getElementById('v_name').textContent = name.trim()
             document.getElementById('v_ic').textContent = ic.trim()
             document.getElementById('v_contact').textContent = contact.trim()
             document.getElementById('v_address').textContent = address.trim()
             document.getElementById('v_email').textContent = email.trim()
             document.getElementById('v_roles').textContent = role.trim()
             
        });
    });
});


function submitForm(action_type, userId = null){
    document.querySelector('#submit').addEventListener('click', function(b){
        b.preventDefault()
        const form = document.getElementById('form')
        action_type == 'edit' ?  form.action = `/staff/account/update/${userId}` :  form.action = `/staff/account/add`
        
        if(action_type == 'add'){
           
            const method = document.querySelector('#method')
            method.value = 'POST'
        }else if(action_type == 'edit'){
             const method = document.querySelector('#method')
            method.value = 'PATCH'
        }

        form.requestSubmit()
     })
}
    
</script>

</x-staff-app-layout>