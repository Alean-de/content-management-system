@include('partials.head')
@include('partials.navbar')

<h2>Message Management</h2>

<div id="alert-container"></div>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>No HP</th>
            <th>Subject</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody id="messageTableBody">
        </tbody>
</table>

<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/message.js') }}"></script>
@include('partials.foot')