music_sharing
=============
1) producer: A music producer when composes a new Mp3
file ,he uploads it to our server along with other details of track
such as singer genre etc. His file’s md5 hash is calculated and
the attached to the begining of the file. This hash is also used
to create a entry in producer’s name in transaction table where
we keep record of all the payments made for that song. The
signed copy of the song is then sent back to the producer and
he is now free to distribute by whatever means he wants to.
2) distributer: Now comes the interesting part of sharing
music but without copy protection as seen in fig 1 . the
first user who pays for the file using our server gets his
hash attached to the starting of Mp3 file along with the
existing producer’s hash.Now he has become an authorized
distributor.In a way he has paid for distribution rights of the
file not the music, because that he might have downloaded
or copied from somewhere freely. Till now he has not made
any profit except paying the full amount for the music.Now
when he distributes and someone decides to pay for the music
like he did, when they pay a part of the payment goes to
the first hash (the hash of previous distributor) of the file say
25% of it and then the remaining goes to the second hash
(the producer’s signature ) of the file.After the payments are
made to the distributor and producer , the existing hash is
replaced with the hash of the user/distributor who has paid
just now . The new distributor gets his unique copy of the
mp3 file of which he is now the rightful distributor. he will
now receive commission if the people choose to pay for the
file they received from him
