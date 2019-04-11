



        <div class="field mb-6">
            <label for="title text-sm mb-2 block"class="label">
                Title
            </label>

            <div class="control">
                <input value="{{$project->title}}" type="text" class="input bg-transparent border border-grey-light  rounded p-2 text-xs w-full" name="title" placeholder="Title">
            </div>

        </div>
        <div class="field">
            <label for="title"class="label">Description</label>

            <div class="control">
                <textarea type="text" class="textarea bg-transparent border border-muted-light rounded p-2 text-xs w-full" name="description" placeholder="Description">{{$project->description}}</textarea>
            </div>

        </div>
        {{csrf_field()}}

        <div class="field">
            <div class="control">
                <button class="button is-link mr-2">Update Project</button>
                <a href="{{$project->path()}}">Cancel</a>
            </div>
        </div>
