<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $event = Event::orderBy('id', 'desc')->get();

        return view('pageevent.index', compact('event'));
    }

    public function create()
    {
        return view('pageevent.event_modal');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_date' => 'required',
            'session_type' => 'required',
            'availability' => 'required',
            'description' => 'required',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $event = new Event;
        $event->event_date = $request->event_date;
        $event->session_type = $request->session_type;
        $event->availability = $request->availability;
        $event->description = $request->description;

        if ($request->hasFile('image_path')) {
            $namaFile = time() . '.' . $request->file('image_path')->extension();
            $request->file('image_path')->move('images/', $namaFile);
            $event->image_path = $namaFile;
        }

        $event->save();

        // Redirect back with a success message
        return redirect()->route('pageevent')->withSuccess('Berhasil Menambahkan Event/Program Baru!');
    }

    public function show($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return redirect()->route('pageevent')->withError('error', 'Event tidak ditemukan');
        }

        return view('pageevent.index', ['event' => $event]);
    }

    public function edit($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return redirect()->route('pageevent')->withError('error', 'Event tidak ditemukan');
        }

        return view('pageevent.index', ['event' => $event]);
    }

    public function updateevent(Request $request, $id)
    {
        $this->validate($request, [
            'event_date' => 'required',
            'session_type' => 'required',
            'availability' => 'required',
            'description' => 'required',
            'image_path' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $event = Event::find($id);

        if (!$event) {
            return response()->json(['error' => false, 'message' => 'Event tidak ditemukan'], 404);
        }

        $event->event_date = $request->input('event_date');
        $event->session_type = $request->input('session_type');
        $event->availability = $request->input('availability');
        $event->description = $request->input('description');

        if ($request->hasFile('image_path')) {
            $namaFile = time() . '.' . $request->file('image_path')->extension();
            $request->file('image_path')->move('images/', $namaFile);
            $event->image_path = $namaFile;
        }

        $event->save();

        return response()->json(['success' => true, 'message' => 'Data Event/Program berhasil diperbarui']);
    }



    public function destroy($id)
    {
        // Temukan pengguna berdasarkan ID dan hapus
        $event = Event::find($id);
        $event->delete();

        // Redirect ke halaman yang sesuai setelah penghapusan
        return response()->json(['success' => true, 'message' => 'Data event berhasil Dihapus']);
    }
}
