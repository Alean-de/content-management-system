<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserApprovalController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'pending');
        $search = $request->input('search', '');

        $users = User::when($status !== 'all', fn($q) => $q->where('status', $status))
        ->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name','LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        })
        ->with('approvedBy')
        ->where('id', '!=', Auth::id())
        ->latest()
        ->paginate(10);

        $counts = [
            'pending'   =>  User::pending()->where('id', '!=', Auth::id())->count(),
            'approved'   =>  User::approved()->where('id', '!=', Auth::id())->count(),
            'rejected'   =>  User::rejected()->where('id', '!=', Auth::id())->count(),
        ];

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                ...$users->toArray(),
                'counts' => $counts,
            ]);
        }

        return view('administrator.userApprovalAdm', compact('users', 'status', 'counts'));
    }

    public function show(User $user)
    {
        return view('administrator.users.show', compact('user'));
    }

    public function approve(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return $this->jsonOrRedirect(
                $request,
                false,
                'Tidak dapat mengubah status akun sendiri',
                403
            );
        }

        $user->update([
            'status'    =>  User::STATUS_APPROVED,
            'approved_by'   =>  Auth::id(),
            'approved_at'   =>  now(),
        ]);

        return $this->jsonOrRedirect(
            $request,
            true,
            "Akun {$user->name} berhasil disetujui."
        );
    }

    public function reject(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return $this->jsonOrRedirect(
                $request,
                false,
                'Tidak dapat mengubah status akun sendiri',
                403
            );
        }

        if ($user->isOwner()) {
            return $this->jsonOrRedirect(
                $request,
                false,
                'Tidak dapat menolak akun Owner.',
                403
            );
        }

        $user->update([
            'status'    =>  User::STATUS_REJECTED,
            'approved_by'   =>  Auth::id(),
            'approved_at'   =>  now(),
        ]);

        return $this->jsonOrRedirect(
            $request,
            true,
            "Akun {$user->name} telah ditolak ."
        );
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return $this->jsonOrRedirect(
                $request,
                false,
                'Tidak dapat menghapus akun sendiri',
                403
            );
        }

        if ($user->isOwner()) {
            return $this->jsonOrRedirect(
                $request,
                false,
                'Tidak dapat menghapus akun Owner.',
                403
            );
        }

        $user->delete();

        return $this->jsonOrRedirect(
            $request,
            true,
            "Akun {$user->name} berhasil dihapus ."
        );
    }

    private function jsonOrRedirect(Request $request, bool $success, string $message, int $status = 200)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'   =>  $success,
                'message'   =>  $message,
            ], $success ? $status : $status);
        }

        $flashKey = $success ? 'success' : 'error';

        return redirect()
            ->route('administrator.users.index')
            ->with($flashKey, $message);
    }
}
