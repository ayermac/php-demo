<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/18
 * Time: 10:40
 */
// 关联更新语句
// A(id, sex, par, c1, c2)
// B(id, age, c1, c2)
// UPDATE A,B SET A.c1 = B.c1, A.c2 = B.c2 WHERE A.id = B.id AND B.age > 50
// UPDATE A INNER JOIN B ON A.id = B.id SET A.c1 = B.c1, A.c2 = B.c2 WHERE B.age > 50

// 交叉连接
//SELECT * FROM A,B(,C) 或者
//SELECT * FROM A CROSS JOIN B (CROSS JOIN C)

// 内连接
// SELECT * FROM A,B WHERE A.id = B.id
// SELECT * FROM A INNER JOIN B ON A.id = B.id

// 联合查询
// SELECT * FROM A UNION SELECT * FROM B UNION ...

// 嵌套查询
// SELECT * FROM A WHERE id IN (SELECT * FROM B)

// 表team
// teamID teamName
// 表match
// matchID hostTeamID guestTeamID matchTime matchResult
// 主队 结果 客队 时间
// SELECT t1.teamName,m.matchResult,t2.teamName,m.matchTime
// FROM match as m LEFT JOIN team as t1 ON m.hostTeamID = t1.teamID
// LEFT JOIN team t2 ON m.guestTeamID = t2.teamID WHERE m.matchTime between "2006-6-1" AND "2006-7-1"