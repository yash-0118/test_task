@foreach($allNews as $news)
<tr>
    <td>{{$news['title']}}</td>
    <td><a href="{{$news['link']}}" target="_blank">Know more</a></td>
    <td>{{$news['pubDate']}}</td>
</tr>
@endforeach