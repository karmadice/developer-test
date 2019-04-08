@extends('layouts.app')
@section('content')

  <div class="container py-3">
    <h1>Users</h1>

    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th class="text-right">Notes</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($users as $user)
          <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td class="text-right">
              <a href="" class="btn btn-sm btn-light" data-toggle="modal" data-target="#notes-modal" v-on:click='openModal("{{$user->name}}", {{$user->id}})'>
                <i class="fas fa-arrow-right"></i>
              </a>
            </td>
          </tr>
        @empty
        <tr>
          <td colspan="3">No users</td>
        </tr>
        @endforelse
        <!-- bootstrap model to add notes (can be converted as component) -->
        <div id="notes-modal" class="modal fade">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="modal-user-name">@{{currentUser.name}}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <div id="modal-notes">
                  <ul class="notes">
                    <li class="note" v-for="note in currentUser.notes">
                      <p class="note-content">@{{note.body}}</p>
                      <small class="note-created">@{{note.created_at}}</small>
                    </li>
                    
                    <li class="note" v-if="currentUser.notes.length === 0">No notes</li>
                  </ul>
                </div>
              </div>
              <div class="modal-footer">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Write note here..." id="new-note" v-model="newNote" />
                  <div class="input-group-append">
                    <button id="add-note" type="button" class="btn btn-success" v-bind:disabled="disableSubmit" v-on:click="addUserNote(newNote, currentUser.id)">Save</button>
                    <button id="cancel-note" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end of modal -->
      </tbody>
    </table>
  </div>

@stop