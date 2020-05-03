@extends('admin.layout')
@section('title', 'หน้าตั้งค่าผู้ใช้งาน')
@section('content')
    <br>
    <div class="w3-container w3-section">
        @if(isset($users))
            @if(session()->has('fail'))
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle">
                        <b class="text-danger">{{ session()->get('fail') }}</b>
                    </i>
                </div>
            @endif
            <div class="table-wrapper-scroll-y">
                <table class="table table-bordered table-dark">
                    <thead>
                    <td colspan="9"><h6>ผู้ใช้งานทั้งหมด</h6>
                    </td>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ชื่อ</th>
                        <th scope="col">อีเมล</th>
                        <th colspan="3" width="20%" scope="col">สถานะผู้ใช้งาน</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as  $index => $user)
                        <tr>
                            <td scope="row">{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->email !== 'Otop5717@gmail.com')
                                    <form action="{{url('user/setting')}}" method="POST" class="form-inline">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <select class="form-control" name="type" style="width: 60%">
                                            <option value="ADMIN" @if('ADMIN' == $user->type) {{ 'selected' }} @endif> ADMIN </option>
                                            <option value="CUSTOMER" @if('CUSTOMER' == $user->type) {{ 'selected' }} @endif> CUSTOMER </option>
                                        </select>
                                        &nbsp;
                                        <button class="btn btn-warning btn-xs">
                                            <i class="fa fa-edit" onclick="return confirm('คุณต้องการเปลี่ยนสถานะผู้ใช้งานใช่หรือไม่ ?')"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <br><br><br>
    <br><br><br>

    <!-- Footer -->
    <footer class="w3-container w3-padding-16 w3-light-grey">
        <h4>FOOTER</h4>
        <p>Powered by w3.css</p>
    </footer>
@endsection
