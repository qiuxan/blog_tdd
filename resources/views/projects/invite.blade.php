
<div class="card flex flex-col">
    <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-blue-light pl-4">


        Invite a User
    </h3>

    <footer>
        <form method="post" action="{{$project->path().'/invitations'}}" class="text-right">
            @csrf
            <div class="mb-3">
                <input type="email" name="email" class="border border-grey-light rounded w-full py-2 px-3" placeholder="Email address">
            </div>

            <button type="submit" class="button">Invite</button>

        </form>

        @include ('errors',['bag'=>'invitations'])
    </footer>
</div>