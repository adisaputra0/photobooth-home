<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhotoboothTemplate;

class PhotoboothTemplateController extends Controller
{
    //
    public function index()
    {
        $templates = PhotoboothTemplate::all();
        return view('photobooth.template', ['templates' => $templates]);
    }
    public function index_admin()
    {
        $templates = PhotoboothTemplate::all();
        return view('photobooth.admin', ['templates' => $templates]);
    }
    public function create()
    {
        return view('photobooth.create_template');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slots' => 'required|integer|min:1',
            'file_path' => 'required|file|mimes:png,jpg,jpeg',
        ]);

        // Handle file upload
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/photobooth_templates'), $filename);

            // Save template to database
            PhotoboothTemplate::create([
                'name' => $request->input('name'),
                'slots' => $request->input('slots'),
                'file_path' => 'uploads/photobooth_templates/' . $filename,
            ]);
        }

        return redirect()->route('photobooth.template.admin')
            ->with('success', 'Template berhasil ditambahkan!');
    }
    public function edit($id)
    {
        $template = PhotoboothTemplate::find($id);
        return view('photobooth.edit_template', ['template' => $template]);
    }
    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'template_id' => 'required|exists:photobooth_templates,id',
            'name' => 'required|string|max:255',
            'file_path' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
            'slots' => 'required|integer|min:1',
        ]);

        // Ambil template berdasarkan ID
        $template = PhotoboothTemplate::findOrFail($request->input('template_id'));

        // Update data dasar
        $template->name = $request->input('name');
        $template->slots = $request->input('slots');

        // Jika ada file baru diupload
        if ($request->hasFile('file_path')) {
            // Hapus file lama jika ada
            if ($template->file_path && file_exists(public_path($template->file_path))) {
                unlink(public_path($template->file_path));
            }

            // Simpan file baru
            $file = $request->file('file_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/photobooth_templates'), $filename);

            // Update path di database
            $template->file_path = 'uploads/photobooth_templates/' . $filename;
        }

        // Simpan perubahan
        $template->save();

        // Redirect kembali ke halaman admin dengan pesan sukses
        return redirect()
            ->route('photobooth.template.admin')
            ->with('success', 'Template berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $template = PhotoboothTemplate::find($id);
        // Hapus file fisik jika ada
        if (file_exists(public_path($template->file_path))) {
            unlink(public_path($template->file_path));
        }
        $template->delete();
        return redirect()->route('photobooth.template.admin')
            ->with('success', 'Template berhasil dihapus!');
    }
}
