<table>
    <thead>
        <tr>
            <th align="center">No</th>
            <th align="center">Part ID</th>
            <th align="center">Part Name</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td>{{ $row['part_id'] }}</td>
                <td>{{ $row['part_name'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>