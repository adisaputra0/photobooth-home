<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IDCardTemplate;

class IDCardController extends Controller
{
    //
    public function index()
    {
        $templates = IDCardTemplate::all();
        return view('idcard.template', ['templates' => $templates]);
    }
    public function index_admin()
    {
        $templates = IDCardTemplate::all();
        return view('idcard.admin', ['templates' => $templates]);
    }
    public function create()
    {
        return view('idcard.create_template');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:png,jpg,jpeg',
        ]);

        // Handle file upload
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/idcard_templates'), $filename);

            // Save template to database
            IDCardTemplate::create([
                'name' => $request->input('name'),
                'file_path' => 'uploads/idcard_templates/' . $filename,
            ]);
        }

        return redirect()->route('idcard.template.admin')
            ->with('success', 'Template berhasil ditambahkan!');
    }
    public function edit($id)
    {
        $template = IDCardTemplate::find($id);
        return view('idcard.edit_template', ['template' => $template]);
    }
    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'template_id' => 'required|exists:idcard_templates,id',
            'name' => 'required|string|max:255',
            'file_path' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
        ]);

        // Ambil template berdasarkan ID
        $template = IDCardTemplate::findOrFail($request->input('template_id'));

        // Update data dasar
        $template->name = $request->input('name');

        // Jika ada file baru diupload
        if ($request->hasFile('file_path')) {
            // Hapus file lama jika ada
            if ($template->file_path && file_exists(public_path($template->file_path))) {
                unlink(public_path($template->file_path));
            }

            // Simpan file baru
            $file = $request->file('file_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/idcard_templates'), $filename);

            // Update path di database
            $template->file_path = 'uploads/idcard_templates/' . $filename;
        }

        // Simpan perubahan
        $template->save();

        // Redirect kembali ke halaman admin dengan pesan sukses
        return redirect()
            ->route('idcard.template.admin')
            ->with('success', 'Template berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $template = IDCardTemplate::find($id);
        // Hapus file fisik jika ada
        if (file_exists(public_path($template->file_path))) {
            unlink(public_path($template->file_path));
        }
        $template->delete();
        return redirect()->route('idcard.template.admin')
            ->with('success', 'Template berhasil dihapus!');
    }
}
