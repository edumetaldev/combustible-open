<div class="table-responsive">
    <table class="table table-striped table-condensed">
        <thead>
        <th>Fecha</th>
        <th>Consumidor</th>
        <th>Monto</th>
        <th>Expendedor</th>
        </thead>
        <tbody>
        @foreach( $consumos as $consumo)
            <tr>
                <td>
                    {{ $consumo->fecha}}
                </td>
                <td>{{ $consumo->consumidor }}</td>
                <td>${{ abs($consumo->monto) }}</td>
                <td>{{ $consumo->expendedor }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>