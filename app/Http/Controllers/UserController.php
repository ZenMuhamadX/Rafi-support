<?php
namespace App\Http\Controllers;

use index;
use App\Models\User;
use App\Models\Trainer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use setasign\Fpdi\Fpdi;

class UserController extends Controller
{
    /**
     * Menampilkan data user yang memiliki role 'user'.
     *
     * @return View
     */
    public function index(Request $request): View
{
    // Ambil query pencarian dari input
    $query = $request->input('query');

    // Jika ada query pencarian, cari user berdasarkan nama atau email
    if ($query) {
        $users = User::where('role', 'user')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%');
            })
            ->paginate(10); // Menggunakan paginate jika ada pencarian
    } else {
        // Jika tidak ada query, ambil semua data user dengan role 'user'
        $users = User::where('role', 'user')->paginate(10); // Tetap menggunakan paginate
    }

    // Mengirimkan data ke view
    return view('admin.DataUser', compact('users'));
}

    public function edituser(User $user)
    {
        return view('admin.EditUser', compact('user'));
    }

    public function updateuser(Request $request, User $user)
    {

        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
        ],[
            'name.required' => 'name wajib di isi',
            'email.required' => 'email wajib di isi',
            'email.unique' => 'email yang anda masukan sudah ada',
        ]
    
    );

        $user->update($request->all());

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        if ($user) {
            return redirect()->route('admin.DataUser')->with('success', 'Berhasil Melakukan Register, Silahkan login.');
        } else {
            return redirect()->back()->withErrors('Username dan Password yang dimasukkan tidak valid.');
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.DataUser')->with('success', 'User deleted successfully.');
    }
    public function trainer()
    {
        // Ambil data untuk role 'trainer'
        $trainers = User::where('role', 'trainer')->paginate(10);

        // Kirim data ke view
        return view('admin.DataTrainer', compact('trainers'));
    }
      public function edittrainer(User $user)
    {
        return view('admin.EditTrainer', compact('user'));
    }

      public function updatetrainer(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
        ],[
            'name.required' => 'name wajib di isi',
            'email.required' => 'email wajib di isi',
            'email.unique' => 'email yang anda masukan sudah ada',
        ]
    );

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->route('admin.dataTrainer')->with('success', 'User updated successfully.');
    }

    public function destroytrainer(User $trainer)
    {
        $trainer->delete();
        return redirect()->route('admin.dataTrainer')->with('success', 'trainer deleted successfully.');
    }

    public function searchtrainer(Request $request)
    {
        // Ambil query pencarian dari input
        $query = $request->input('query');

        // Cari user dengan role "user" yang cocok dengan query
        $trainers = User::where('role', 'trainer')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%');
            })
            ->paginate(10);

        // Return ke view dengan hasil pencarian
        return view('admin.dataTrainer', compact('trainers'));
    }

    public function sertifikat(Request $request){
        $nama = $request->post('nama');
        $outputfile = public_path(). 'dcc.pdf';
        $this->fillPDF(public_path(). '/master/dcc.pdf',$outputfile,$nama);
        
        return response()->file($outputfile);
    }
    public function fillPDF($file,$outputfile,$nama){
        $fpdi = new FPDI;
        $fpdi->setSourceFile($file);
        $template = $fpdi->importPage(1);
        $size = $fpdi->getTemplateSize($template);
        $fpdi->AddPage($size['orientation'],array($size['width'],$size['height']));
        $fpdi->useTemplate($template);
        $top = 105;
        $right = 105;
        $name = $nama;
        $fpdi->SetFont("times","",40);
        $fpdi->SetTextColor(25,26,25);
        $fpdi->Text($right,$top,$name);

        return $fpdi->Output($outputfile,'F'); 
    }

}